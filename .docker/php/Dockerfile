# Use a imagem oficial do PHP 8.0.6
FROM php:8.0.6-fpm

# Instale as dependências do Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do Laravel para o contêiner
COPY . /var/www/html

# Instale as dependências do Composer
RUN composer install

# Configure as permissões do Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponha a porta 9000 para o PHP-FPM
EXPOSE 9000

# CMD ["php-fpm"]
