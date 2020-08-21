FROM php:7.3.1-stretch

ENTRYPOINT [ "/bin/bash " ]

COPY [".", "/app/"]

RUN apt-get update

RUN apt-get install -y curl
RUN docker-php-ext-install mbstring
RUN apt-get install -y git
RUN apt-get install -y unzip
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

WORKDIR /app
    

EXPOSE 8010

ADD ./wait /wait
RUN chmod +x /wait