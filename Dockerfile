# Set the base image for subsequent instructions
FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.lock and composer.json
COPY composer.lock composer.json /app/

# Set working directory
WORKDIR /app

COPY . /app

RUN cp .env-docker .env
RUN rm -rf /app/vendor
RUN rm -rf /app/vendor
RUN rm -rf /app/public/storage
RUN rm -rf /app/bootstrap/cache/config.php
RUN chmod 755 storage /app/bootstrap/cache
RUN composer install --no-scripts
RUN php artisan storage:link

EXPOSE 8000
