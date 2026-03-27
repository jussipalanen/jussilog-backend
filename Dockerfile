# Production PHP runtime for Laravel API backend (no frontend build stage)
ARG PHP_VERSION=8.4

FROM php:${PHP_VERSION}-fpm-alpine

ARG UID=1000
ARG GID=1000
# Set to "true" in docker-compose for local dev to include require-dev packages in the image.
# Leave false (default) for production builds so dev packages are never shipped.
ARG INSTALL_DEV_DEPS=false

RUN addgroup -g ${GID} laravel && \
    adduser -D -u ${UID} -G laravel laravel

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    sqlite-dev \
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
    && docker-php-ext-install pdo_sqlite pdo_mysql gd opcache

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

COPY --chown=laravel:laravel . .

# SQLite database file (used in local dev via docker-compose.sqlite.yml)
RUN mkdir -p database bootstrap/cache && \
    touch database/database.sqlite && \
    chmod 664 database/database.sqlite && \
    if [ "${INSTALL_DEV_DEPS}" = "true" ]; then \
        composer install --optimize-autoloader --no-interaction --no-progress; \
    else \
        composer install --optimize-autoloader --no-dev --no-interaction --no-progress; \
    fi && \
    chmod -R 775 storage bootstrap/cache database && \
    php artisan package:discover --ansi && \
    php artisan vendor:publish --provider="Knuckles\Scribe\ScribeServiceProvider" --tag=scribe-assets --force

# Copy PHP-FPM pool configuration
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy OPcache configuration
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
