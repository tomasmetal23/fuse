FROM php:7.3.1-stretch


COPY [".", "/app/"]

RUN echo "memory_limit = -1" > /usr/local/etc/php/conf.d/memory_limit.ini && \
    echo "extension=pdo_pgsql" > /usr/local/etc/php/conf.d/pdo_pgsql.ini && \
    echo "extension=pgsql" > /usr/local/etc/php/conf.d/pgsql.ini

RUN apt-get update && \
    apt-get install -y \
        curl \
        nginx \
        git \
        unzip \
        libpng-dev \
        libpq-dev 

RUN docker-php-ext-install mbstring && \
    docker-php-ext-install gd && \
    docker-php-ext-install pgsql && \
    docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php

COPY default /etc/nginx/sites-available

RUN mv composer.phar /usr/local/bin/composer

RUN chmod +x /usr/local/bin/composer

WORKDIR /app

RUN composer require niklasravnsborg/laravel-pdf

RUN composer install

RUN composer update --no-scripts  

EXPOSE 8010
