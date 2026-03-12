# Production PHP runtime for Laravel API backend (no frontend build stage)
ARG PHP_VERSION=8.2
ARG UID=1000
ARG GID=1000

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
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_sqlite pdo_mysql opcache gd

# OPcache tuned for production (validate_timestamps=0 — files never change in the image)
# memory_consumption=64 is plenty for a small Laravel API; leaves more room for PHP workers
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=64'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=8000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.save_comments=1'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

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

# SQLite database file (used in local dev via docker-compose.sqlite.yml)
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

# Publish Scribe CSS/JS assets so they are baked into the image
RUN php artisan vendor:publish --provider="Knuckles\Scribe\ScribeServiceProvider" --tag=scribe-assets --force

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
