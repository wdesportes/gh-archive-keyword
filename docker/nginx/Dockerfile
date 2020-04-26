FROM php:7.4-alpine

RUN apk add --no-cache --update nginx composer bash php7-fpm php7-mysqli php7-pdo_mysql php7-tokenizer php7-session && \
    mkdir -p /run/nginx && \
    docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY ./default-nginx.conf /etc/nginx/conf.d/default.conf
COPY ./docker-entrypoint.sh /docker-entrypoint.sh

ENTRYPOINT [ "/docker-entrypoint.sh" ]
