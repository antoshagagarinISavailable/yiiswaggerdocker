# PHP CLI
FROM php:8.1.24-cli-alpine3.18 as cli

COPY ./docker/php/cli/conf.d/* $PHP_INI_DIR/conf.d
COPY ./docker/php/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer-2 opcache pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

RUN apk --no-cache add bash

COPY ./ ./

WORKDIR /

RUN rm -rf /vendor \
    && composer --no-ansi --no-interaction install --no-progress

# PHP-FPM
FROM php:8.1.24-fpm-alpine3.18 as fpm

COPY ./docker/php/fpm/conf.d/* $PHP_INI_DIR/conf.d
COPY ./docker/php/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions opcache pdo_mysql

RUN apk --no-cache add bash

COPY --from=cli / /var/www/html

WORKDIR /var/www/html

CMD php-fpm
EXPOSE 9000

# NGINX
FROM nginx:1.20.2-alpine as nginx

COPY docker/nginx/conf.d/* /etc/nginx/conf.d

COPY --from=cli /web /var/www/html/web

RUN apk update && apk upgrade && apk add --no-cache bash

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80

FROM node:20.6.0-alpine3.18

ARG USER='node'
ARG GROUP='node'

RUN apk add python3 make g++

WORKDIR /app

USER ${USER}:${GROUP}
