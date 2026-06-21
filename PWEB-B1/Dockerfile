FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    bash \
    curl \
    git \
    nginx \
    supervisor \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        xml \
        gd \
        bcmath \
        exif \
        pcntl \
    && rm -rf /var/cache/apk/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . /var/www

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Copy nginx config
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Copy supervisor config
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Copy startup script
COPY docker/startup.sh /startup.sh
RUN chmod +x /startup.sh

# Copy env & generate app key
RUN cp /var/www/.env.bdt /var/www/.env && \
    php artisan config:clear && \
    php artisan key:generate

# Set permissions - MUST be after artisan commands (they create log file as root)
RUN mkdir -p /var/www/public/img && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/img && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/img

# Expose port
EXPOSE 80

# Run startup script (waits for DB, runs migrate/seed, then starts supervisor)
CMD ["/startup.sh"]
