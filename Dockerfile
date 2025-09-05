FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    git \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    mariadb-client \
    gettext \
    bash \
    openssh \
    libxml2-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl opcache \
    && docker-php-ext-enable opcache

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
COPY ./api/wegia /var/www/html
WORKDIR /var/www/html

COPY ./api/wegia/.env /var/www/html/.env

COPY ./api/config/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
COPY ./api/config/nginx.conf /etc/nginx/nginx.conf
COPY ./api/config/custom-entrypoint.sh /usr/local/bin/custom-entrypoint.sh

RUN chmod +x /usr/local/bin/custom-entrypoint.sh

RUN sed -i 's|listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf


EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/custom-entrypoint.sh"]
