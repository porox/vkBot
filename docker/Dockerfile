FROM composer:1.6
FROM php:7.2-fpm-alpine3.8

ARG APP_ENV=dev
ENV APP_ENV $APP_ENV
ENV APCU_VERSION 5.1.12
ENV XDEBUG_VERSION 2.6.0
ENV MEMCACHED_VERSION 3.0.4
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk update \
    && apk add --no-cache --virtual .persistent-deps \
        nginx \
        gettext \
    && rm -rf /var/cache/*

# PHP install
RUN set -xe \
	&& apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        zlib-dev \
        gettext-dev \
        sqlite-dev  \
        libxslt-dev \
        freetype-dev libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && if [ "$APP_ENV" == "dev" ]; \
       then \
         pecl install xdebug-${XDEBUG_VERSION}; \
         docker-php-ext-enable --ini-name xdebug.ini xdebug; \
         { \
           echo "xdebug.remote_enable=On"; \
           echo "xdebug.remote_autostart=Off"; \
         }  >> /usr/local/etc/php/conf.d/xdebug.ini; \
       fi \
    && docker-php-ext-install \
        bcmath \
        mbstring \
        intl \
        pdo  pdo_sqlite \
        zip \
        gd \
        gettext \
        xsl \
    && pecl install \
        apcu-${APCU_VERSION} \
    && docker-php-ext-enable --ini-name 20-apcu.ini apcu \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache \
    && runDeps="$( \
    	scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
    		| tr ',' '\n' \
    		| sort -u \
    		| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --no-cache --virtual .php-phpexts-rundeps $runDeps \
    && apk del .build-deps \
    && rm -rf /tmp/pear \
        /var/cache/*

WORKDIR /var/www/html

COPY --from=0 /usr/bin/composer /usr/bin/composer
# Copy application files into the app directory.
COPY . ./
COPY docker/config/php/php.ini /usr/local/etc/php/php.ini
COPY docker/config/nginx/conf.d /etc/nginx/conf.d/
COPY docker/docker-* /usr/local/bin/

RUN composer install --no-interaction

RUN ln -s /var/www/html/bin/console /usr/bin/console
RUN mkdir -p var/cache var/log /run/nginx /var/nginx/cache var/uploads \
     && chown -R www-data:root var/cache var/log var/uploads

EXPOSE 80
CMD ["docker-init"]