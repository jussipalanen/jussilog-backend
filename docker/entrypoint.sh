#!/bin/sh
set -e

echo "Starting JussiLog Backend..."

# Get port from environment (Cloud Run sets this, default to 8080)
PORT="${PORT:-8080}"
echo "Using port: $PORT"

# Update Nginx configuration with the correct port
sed -i "s/listen 8080/listen $PORT/g" /etc/nginx/http.d/default.conf
sed -i "s/listen \[::\]:8080/listen \[::\]:$PORT/g" /etc/nginx/http.d/default.conf

# Ensure database directory exists
mkdir -p /var/www/html/database

# Ensure storage and cache directories exist and have proper permissions
mkdir -p /var/www/html/storage/framework/cache \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Fix ownership and permissions for bind-mounted directories
# This ensures the laravel user can write to these directories
chown -R laravel:laravel /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database 2>/dev/null || true

# Create SQLite database file if it doesn't exist
if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "Creating SQLite database file..."
    touch /var/www/html/database/database.sqlite
    chown laravel:laravel /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
fi

# Wait a moment for filesystem to be ready
sleep 1

# Run database migrations as laravel user
echo "Running database migrations..."
su laravel -s /bin/sh -c "php artisan migrate --force --no-interaction"

# Create storage link if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage link..."
    su laravel -s /bin/sh -c "php artisan storage:link" || true
fi

# Production optimizations (skip in local development)
if [ "$APP_ENV" != "local" ]; then
    echo "Running production optimizations..."
    su laravel -s /bin/sh -c "php artisan config:cache"
    su laravel -s /bin/sh -c "php artisan route:cache"
    su laravel -s /bin/sh -c "php artisan view:cache"
else
    echo "Local development mode - skipping cache optimizations"
    # Ensure route/config/view caches never mask live code changes in local dev.
    su laravel -s /bin/sh -c "php artisan optimize:clear" || true
fi

echo "Starting PHP-FPM..."
# Start PHP-FPM in background
php-fpm -D

echo "Starting Nginx on port $PORT..."
# Start Nginx in foreground (keeps container running)
exec nginx -g 'daemon off;'
