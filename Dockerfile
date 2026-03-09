# Multi-stage build for Laravel with Vite frontend assets
ARG PHP_VERSION=8.1
ARG NODE_VERSION=20
ARG UID=1000
ARG GID=1000

# Stage 1: Build frontend assets
FROM node:${NODE_VERSION}-alpine AS frontend-builder

WORKDIR /app

# Copy ONLY package files first (better cache)
COPY package*.json vite.config.js ./

# Install dependencies (cached if package.json unchanged)
RUN npm ci --prefer-offline --no-audit

# Copy resources AFTER deps installed
COPY resources ./resources

# Build
RUN npm run build

# Stage 2: Production PHP runtime
FROM php:${PHP_VERSION}-fpm-alpine

ARG UID=1000
ARG GID=1000

# Create laravel user with host UID/GID
RUN addgroup -g ${GID} laravel && \
    adduser -D -u ${UID} -G laravel laravel

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    sqlite-dev \
    mysql-client \
    shadow \
    && docker-php-ext-install pdo_sqlite pdo_mysql opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy ONLY composer files first (better cache)
COPY composer.json composer.lock ./

# Install PHP dependencies (cached if composer files unchanged)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist --no-scripts --no-autoloader

# Copy application files AFTER dependencies installed
COPY . .

# Copy built frontend assets from stage 1
COPY --from=frontend-builder /app/public/build ./public/build

# Create SQLite database directory and file
RUN mkdir -p database && \
    touch database/database.sqlite && \
    chmod 664 database/database.sqlite

# Ensure Laravel cache directories exist before running artisan commands
RUN mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views

# Clear bootstrap cache to avoid cached dev dependencies
RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php

# Complete composer autoloader
RUN composer dump-autoload --optimize --classmap-authoritative && \
    php artisan package:discover --ansi

# Set permissions for Laravel
RUN chown -R laravel:laravel /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Copy PHP-FPM pool configuration
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port (Cloud Run will inject PORT env variable)
EXPOSE 8080

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
