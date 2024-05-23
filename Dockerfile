FROM php:8.2.16-apache as base

RUN a2enmod rewrite



FROM base as dev
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY conf.d/* $PHP_INI_DIR/conf.d
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug
USER www-data



FROM base as prod
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY . /var/www/html/
USER www-data
