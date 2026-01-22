# Use a working Laravel PHP image
FROM webdevops/php-nginx:8.2-alpine

# Install PostgreSQL support
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy application
COPY . .

# Remove .env files
RUN rm -f .env .env.example || true

# Install dependencies (skip scripts that might fail)
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache

# Copy your configurations
COPY nginx/default.conf /opt/docker/etc/nginx/vhost.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]