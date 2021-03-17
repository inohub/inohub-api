FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y --no-install-recommends \
    zip \
    wget \
    nano \
    unzip \
    curl \
    mc \
    jpegoptim optipng pngquant gifsicle

RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-install pcntl bcmath opcache

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash
RUN apt-get install --yes nodejs
RUN node -v
RUN npm -v

RUN apt-get install -y supervisor

# Changing Workdir
WORKDIR /application
