FROM php:8.2.16-apache as base

RUN #pecl install apcu
RUN a2enmod rewrite

COPY php.ini "$PHP_INI_DIR/php.ini"

USER www-data

FROM base as dev


FROM base as prod
COPY . /var/www/html/