FROM php:8..0.6-fpm

USER root

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    apt-utils \
    build-essential \
    openssl \
    libfreetype6-dev \
    libmcrypt-dev \
    libicu-dev \
    libgettextpo-dev \
    libxml2-dev \
    libssl-dev \
    libzip-dev \
    zip \
    cron \
    git \
    supervisor \
    ghostscript \
    libmagickwand-dev --no-install-recommends \
    tesseract-ocr \
    tesseract-ocr-por \
    && pecl install imagick

# Clear cache
RUN apt-get clean \
    && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql \
    gd \
    mbstring \
    mysqli \
    sockets \
    zip \
    && docker-php-ext-enable imagick

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/html

RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-ansi --no-dev --no-suggest --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Run artisan commands
RUN php artisan migrate --force
RUN php artisan storage:link

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan event:cache

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www
