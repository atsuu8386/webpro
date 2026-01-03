# Multi-stage build for optimized production image
FROM php:8.4-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    libxml2-dev \
    curl \
    git \
    unzip \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        mbstring \
        pcntl \
        bcmath \
        intl \
        opcache \
        exif \
        soap

# Install Redis extension
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Development stage
FROM base AS development

# Install development dependencies
RUN apk add --no-cache \
    bash \
    vim \
    procps

# Copy php.ini for development
COPY docker/php-fpm/php.ini /usr/local/etc/php/php.ini

# Create Laravel directories if they don't exist
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data

CMD ["php-fpm"]

# Production build stage
FROM base AS production-builder

# Copy application files
COPY --chown=www-data:www-data . /var/www/html

# Install production dependencies only
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --prefer-dist \
    && composer clear-cache

# Production stage
FROM base AS production

# Copy production php.ini
COPY docker/php-fpm/php-prod.ini /usr/local/etc/php/php.ini

# Copy application from builder
COPY --from=production-builder --chown=www-data:www-data /var/www/html /var/www/html

# Optimize Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan event:cache

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD php artisan inspire || exit 1

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
