# --- Stage 1: Builder ---
FROM php:8.2-fpm-alpine AS builder

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code
COPY . .

# Remove .env files
RUN rm -f .env .env.example || true

# Install PHP extensions
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql bcmath

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# --- Stage 2: Final Runtime ---
FROM php:8.2-fpm-alpine

# Install runtime dependencies
RUN apk add --no-cache nginx supervisor curl postgresql-client \
    && apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql bcmath

# Configure PHP-FPM
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy application from builder
COPY --from=builder /var/www/html /var/www/html

# Setup permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy configuration files
COPY nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]