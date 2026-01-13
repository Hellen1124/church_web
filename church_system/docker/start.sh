

#!/bin/sh

# 1. Run migrations automatically on startup
# The --force is required for production environments
echo "🚀 Running database migrations..."
php artisan migrate --force

# 2. Start Supervisor (which starts Nginx and PHP-FPM)
echo "🎬 Starting Supervisor..."
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf