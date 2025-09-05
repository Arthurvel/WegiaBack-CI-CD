FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    bash \
    curl \
    git \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libonig-dev \
    mariadb-client \
    gettext \
    openssh-client \
    libxml2-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN useradd -r -s /sbin/nologin nginx

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./wegia /var/www/html

WORKDIR /var/www/html

COPY ./config/custom-entrypoint.sh /usr/local/bin/custom-entrypoint.sh
COPY ./config/nginx.conf /etc/nginx/nginx.conf
RUN chmod +x /usr/local/bin/custom-entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/custom-entrypoint.sh"]