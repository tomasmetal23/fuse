FROM php:7.1.3-cli

COPY [".", "/app/"]

WORKDIR /app

RUN apt-get update

RUN apt install curl php-mbstring git unzip

RUN curl -sS https://getcomposer.org/installer | php

RUN mv composer.phar /usr/local/bin/composer

RUN chmod +x /usr/local/bin/composer

EXPOSE 8010

CMD ["php", "-S localhost:8010 -t public"]