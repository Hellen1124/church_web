FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache curl git postgresql-dev nginx supervisor \
    libpng-dev libzip-dev icu-dev oniguruma-dev freetype-dev libjpeg-turbo-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_pgsql bcmath gd zip intl mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy only composer files first
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Copy the rest
COPY . .

# Remove .env files
RUN rm -f .env .env.example || true

# ⭐⭐⭐ FIXED: Alpine Linux permissions ⭐⭐⭐
# Create user and group if they don't exist
RUN addgroup -g 1000 www-data || true && \
    adduser -u 1000 -G www-data -S www-data || true

# Set permissions (ignore errors if user doesn't exist)
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R 1000:1000 storage bootstrap/cache || true

# Copy configuration files
COPY nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]