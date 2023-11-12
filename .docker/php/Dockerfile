FROM php:8.0.6-fpm

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
    git \
    supervisor \
    ghostscript \
    libmagickwand-dev --no-install-recommends

# setting up xdebug
# https://gist.github.com/chadrien/c90927ec2d160ffea9c4
RUN yes | pecl install xdebug \
        && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

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
    zip 

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www
