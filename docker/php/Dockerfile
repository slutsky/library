FROM php:7.4.33-fpm-alpine

ARG WWW_DATA_UID=1000 WWW_DATA_GID=1000

RUN apk add --no-cache shadow &&\
    usermod -u ${WWW_DATA_UID} www-data &&\
    groupmod -g ${WWW_DATA_GID} www-data &&\
    apk del shadow

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" &&\
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer --version=2.5.8 &&\
    php -r "unlink('composer-setup.php');"

RUN docker-php-ext-install pdo_mysql &&\
    docker-php-ext-enable pdo_mysql

RUN apk add --no-cache icu-dev &&\
    docker-php-ext-configure intl &&\
    docker-php-ext-install intl

USER www-data

WORKDIR /app
