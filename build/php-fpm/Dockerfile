FROM php:7.3-fpm-alpine

ENV TERM xterm

COPY build/php-fpm/php.ini /usr/local/etc/php/php.ini
COPY build/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN apk upgrade --update && apk add bash git openssh-client make curl postgresql-dev libzip-dev \
    && docker-php-ext-install opcache json pdo pdo_pgsql pgsql zip bcmath \
    && printf "\n%s\n%s" "@edge http://dl-cdn.alpinelinux.org/alpine/edge/main" "@testing http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
    && apk add rabbitmq-c-dev@edge g++ autoconf make postgresql-dev@edge \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && apk add --no-cache --virtual .build-deps g++ autoconf make

RUN rm -rf /apk /tmp/* /var/cache/apk/*

COPY composer.json /var/www/url-shortener/composer.json
COPY composer.lock /var/www/url-shortener/composer.lock
COPY public /var/www/url-shortener/public
COPY app /var/www/url-shortener/app
COPY bootstrap /var/www/url-shortener/bootstrap
COPY database /var/www/url-shortener/database
COPY resources /var/www/url-shortener/resources
COPY routes /var/www/url-shortener/routes
COPY artisan /var/www/url-shortener/artisan
COPY tests /var/www/url-shortener/tests

WORKDIR /var/www/url-shortener

RUN echo "install composer ..." \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

EXPOSE 9000

CMD ["php-fpm", "--allow-to-run-as-root"]
