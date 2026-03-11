ARG PHP_VERSION=8.1

FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --classmap-authoritative \
    --no-scripts

FROM php:${PHP_VERSION}-fpm-alpine

ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} laravel && \
    adduser -D -u ${UID} -G laravel laravel && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS sqlite-dev && \
    apk add --no-cache nginx mysql-client sqlite-libs su-exec && \
    docker-php-ext-install pdo_sqlite pdo_mysql opcache && \
    apk del .build-deps

# Set working directory
WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --chown=laravel:laravel . .
COPY --from=composer-builder --chown=laravel:laravel /app/vendor ./vendor

RUN mkdir -p \
        bootstrap/cache \
        database \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs && \
    touch database/database.sqlite && \
    chmod 664 database/database.sqlite && \
    chmod -R 775 storage bootstrap/cache database && \
    composer dump-autoload --optimize --classmap-authoritative --no-dev --no-interaction && \
    php artisan package:discover --ansi && \
    php artisan vendor:publish --provider="Knuckles\Scribe\ScribeServiceProvider" --tag=scribe-assets --force

# Copy PHP-FPM pool configuration
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

# OPCache settings — edit docker/opcache.ini and redeploy to change tuning.
COPY docker/opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
