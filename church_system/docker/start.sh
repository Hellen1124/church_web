#!/bin/sh
# Exit on any error
set -e

echo "🚀 Starting Final Deployment Steps..."

# 1. Create folders & set permissions
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 2. RUN MIGRATIONS FIRST
# This is the most important part. We must build the tables before touching them.
echo "📦 Running database migrations..."
php artisan migrate --force --no-interaction

# 3. OPTIMIZE (We skip manual cache:clear because config:cache does it better)
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🚀 App is ready! Starting server..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf