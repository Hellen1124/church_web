# This is your Dockerfile for Render
# File location: C:\xampp\htdocs\church_web\church_system\Dockerfile

# Multi-stage build for smaller image

FROM php:8.2-fpm-alpine AS builder

# Install build dependencies (Added more libraries to ensure extensions build correctly)
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    icu-dev

# Install PHP extensions
# We added 'intl' and 'gd' configuration for better Laravel support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    gd \
    zip \
    intl



# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
WORKDIR /var/www/html
COPY . .

# Install dependencies (production only)
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Final stage
FROM php:8.2-fpm-alpine

# Install runtime dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    postgresql-dev \
    libpng \
    libzip \
    shadow

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    gd \
    zip

# Copy built application from builder stage
COPY --from=builder /var/www/html /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Create www-data user if it doesn't exist and set UID to 1000
RUN if ! getent passwd www-data > /dev/null 2>&1; then \
      adduser -u 1000 -D -S -G www-data www-data; \
    fi

# Copy nginx configuration
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Create and configure supervisor
RUN mkdir -p /etc/supervisor/conf.d
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Switch to non-root user
USER www-data

# Create necessary directories
RUN mkdir -p storage/framework/{sessions,views,cache}

# Switch back to root for service management
USER root

# Expose port 8080 (Render free tier requirement)
EXPOSE 8080

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=30s --retries=3 \
  CMD curl -f http://localhost:8080 || exit 1

# Start the application
CMD ["/start.sh"]