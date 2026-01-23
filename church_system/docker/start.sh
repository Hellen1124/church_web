#!/bin/sh
set -e

echo "🚀 FINAL ATTEMPT: Clearing everything and rebuilding..."

# 1. Folders & Permissions
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 2. FORCE DOCTRINE/DBAL (Needed for modifying columns in Postgres)
# If your migration #25 uses ->change(), you need this.
composer require doctrine/dbal --no-interaction --no-scripts

# 3. REBUILD DATABASE
echo "📦 Running migrate:fresh..."
php artisan migrate:fresh --force --no-interaction

# 4. OPTIMIZE
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🎬 SUCCESS! Starting server..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf