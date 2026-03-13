# Production PHP runtime for Laravel API backend (no frontend build stage)
ARG PHP_VERSION=8.2
ARG UID=1000
ARG GID=1000

FROM php:${PHP_VERSION}-fpm-alpine

ARG UID=1000
ARG GID=1000

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
    chromium \
    nss \
    harfbuzz \
    ca-certificates \
    ttf-freefont \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_sqlite pdo_mysql gd opcache \
    && { \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=0'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.save_comments=1'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.revalidate_freq=0'; \
    } > /usr/local/etc/php/conf.d/docker-php-opcache.prod.ini

# Tell Browsershot/Chromium where the binary lives and disable sandbox (required in containers)
ENV CHROME_PATH=/usr/bin/chromium-browser
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
ENV PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser

# Install puppeteer globally for Browsershot (skips bundled Chromium download)
RUN npm install -g puppeteer

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --chown=laravel:laravel . .
COPY --from=composer-builder --chown=laravel:laravel /app/vendor ./vendor

# Copy application files AFTER dependencies installed
COPY . .

# SQLite database file (used in local dev via docker-compose.sqlite.yml)
RUN mkdir -p database && \
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
