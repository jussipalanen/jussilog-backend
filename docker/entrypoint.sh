#!/bin/sh
set -e

echo "Starting JussiLog Backend..."

# Get port from environment (Cloud Run sets this, default to 8080)
PORT="${PORT:-8080}"
echo "Using port: $PORT"

# Update Nginx configuration with the correct port
sed -i "s/listen 8080/listen $PORT/g" /etc/nginx/http.d/default.conf
sed -i "s/listen \[::\]:8080/listen \[::\]:$PORT/g" /etc/nginx/http.d/default.conf

# Ensure storage and cache directories exist and have proper permissions
mkdir -p /var/www/html/storage/framework/cache \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Fix ownership and permissions for bind-mounted directories
# This ensures the laravel user can write to these directories
chown -R laravel:laravel /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Get database connection type
DB_CONNECTION="${DB_CONNECTION:-mysql}"
echo "Database connection: $DB_CONNECTION"

# Handle database-specific setup
if [ "$DB_CONNECTION" = "sqlite" ]; then
    echo "Setting up SQLite database..."
    
    # Ensure database directory exists
    mkdir -p /var/www/html/database
    
    # Create SQLite database file if it doesn't exist
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        echo "Creating SQLite database file..."
        touch /var/www/html/database/database.sqlite
        chown laravel:laravel /var/www/html/database/database.sqlite
        chmod 664 /var/www/html/database/database.sqlite
    fi
    
    # Fix ownership and permissions for SQLite database
    chown laravel:laravel /var/www/html/database /var/www/html/database/database.sqlite 2>/dev/null || true
    chmod -R 775 /var/www/html/database 2>/dev/null || true

elif [ "$DB_CONNECTION" = "mysql" ]; then
    echo "Setting up MySQL database..."
    
    DB_HOST="${DB_HOST:-127.0.0.1}"
    DB_SOCKET="${DB_SOCKET:-}"
    DB_PORT="${DB_PORT:-3306}"
    DB_DATABASE="${DB_DATABASE:-jussilog}"
    DB_USERNAME="${DB_USERNAME:-jussilog}"
    DB_PASSWORD="${DB_PASSWORD:-jussilog}"
    
    if [ -n "$DB_SOCKET" ]; then
        echo "Connecting via Unix socket: $DB_SOCKET (Cloud SQL — no wait needed)"
        MYSQL_CONN_ARGS="--socket=$DB_SOCKET"
    else
        # TCP path (local Docker) — wait a few seconds for MySQL to come up
        echo "Connecting via TCP: $DB_HOST:$DB_PORT"
        MYSQL_CONN_ARGS="-h $DB_HOST -P $DB_PORT --ssl=0"
        echo "Waiting for MySQL..."
        MAX_RETRIES=15
        RETRY_COUNT=0
        DB_READY=false
        while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
            if mysqladmin ping $MYSQL_CONN_ARGS -u "$DB_USERNAME" -p"$DB_PASSWORD" --silent 2>/dev/null; then
                DB_READY=true
                break
            fi
            RETRY_COUNT=$((RETRY_COUNT + 1))
            echo "  attempt $RETRY_COUNT/$MAX_RETRIES..."
            sleep 2
        done
        if [ "$DB_READY" != "true" ]; then
            echo "WARNING: Could not connect to MySQL after $MAX_RETRIES attempts — continuing anyway."
        fi
    fi

    # Ensure database exists (best-effort — Cloud SQL user may lack CREATE DATABASE)
    mysql $MYSQL_CONN_ARGS -u "$DB_USERNAME" -p"$DB_PASSWORD" \
        -e "CREATE DATABASE IF NOT EXISTS \`$DB_DATABASE\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" \
        2>/dev/null || true
    echo "Database ready!"
fi

# In local development: run a full composer install (including dev dependencies)
# so tools like PHPUnit/Faker are accessible inside the container.
# In production: vendor is already baked into the image by the Dockerfile — skip to
# avoid redundant network calls and accidental installation of dev packages.
if [ "$APP_ENV" = "local" ]; then
    echo "Installing Composer dependencies (local, with dev)..."
    su laravel -s /bin/sh -c "composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader" || true
else
    echo "Skipping runtime composer install (vendor baked into image for $APP_ENV)."
fi

# Run database migrations
echo "Running database migrations..."
if ! su laravel -s /bin/sh -c "php artisan migrate --force --no-interaction"; then
    echo "WARNING: Migration step failed during startup; continuing to start web server."
fi

# Create storage link if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage link..."
    su laravel -s /bin/sh -c "php artisan storage:link" || true
fi

# Production optimizations (skip in local development)
if [ "$APP_ENV" != "local" ]; then
    echo "Running production optimizations..."
    su laravel -s /bin/sh -c "php artisan optimize"
else
    echo "Local development mode - skipping cache optimizations"
    su laravel -s /bin/sh -c "php artisan optimize:clear" || true
fi

echo "Starting PHP-FPM..."
# Start PHP-FPM in background
php-fpm -D

echo "Starting Nginx on port $PORT..."
# Start Nginx in foreground (keeps container running)
exec nginx -g 'daemon off;'

