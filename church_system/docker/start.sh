#!/bin/sh

# Exit on any error
set -e

echo "🚀 Setting up Laravel application on Render..."

# Debug: Show environment
echo "=== Environment ==="
echo "APP_ENV: $APP_ENV"
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_HOST: $DB_HOST"
echo "DB_DATABASE: $DB_DATABASE"
echo "=================="

# Wait for PostgreSQL (Render free tier needs this)
if [ ! -z "$DB_HOST" ]; then
    echo "⏳ Waiting for PostgreSQL to be ready..."
    for i in $(seq 1 10); do
        if PGPASSWORD="$DB_PASSWORD" psql -h "$DB_HOST" -U "$DB_USERNAME" -d "$DB_DATABASE" -c '\q' 2>/dev/null; then
            echo "✅ PostgreSQL is ready!"
            break
        else
            echo "⏳ Attempt $i/10: PostgreSQL not ready, sleeping..."
            sleep 5
        fi
        if [ $i -eq 10 ]; then
            echo "❌ ERROR: Could not connect to PostgreSQL after 50 seconds"
            exit 1
        fi
    done
fi

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create necessary directories
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Generate key if not set
php artisan key:generate --force --no-interaction 2>/dev/null || true

# Run migrations
echo "📦 Running database migrations..."
php artisan migrate --force --no-interaction
echo "✅ Migrations completed!"

# Cache for production
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "🎬 Starting Supervisor with Nginx and PHP-FPM..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf