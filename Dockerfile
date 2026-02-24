# Multi-stage build for Laravel with Vite frontend assets
ARG PHP_VERSION=8.1
ARG NODE_VERSION=20

# Stage 1: Build frontend assets
FROM node:${NODE_VERSION}-alpine AS frontend-builder

WORKDIR /app

# Copy package files
COPY package*.json vite.config.js ./
COPY resources ./resources

# Install dependencies and build
RUN npm ci
RUN npm run build

# Stage 2: Production PHP runtime
FROM php:${PHP_VERSION}-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    sqlite-libs \
    sqlite \
    sqlite-dev \
    zip \
    unzip \
    curl \
    bash \
    && docker-php-ext-install pdo_sqlite pdo_mysql opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Copy application files
COPY . .

# Install PHP dependencies (production only, optimized)
RUN mkdir -p bootstrap/cache && \
    composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist --no-scripts

# Regenerate bootstrap cache without dev dependencies
RUN mkdir -p bootstrap/cache && \
    rm -rf bootstrap/cache/*.php && \
    php artisan package:discover --ansi

# Copy built frontend assets from stage 1
COPY --from=frontend-builder /app/public/build ./public/build

# Create SQLite database directory and file
RUN mkdir -p database && \
    touch database/database.sqlite

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port (Cloud Run will inject PORT env variable)
EXPOSE 8080

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
