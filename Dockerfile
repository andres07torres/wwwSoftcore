# =========================================================================
# STAGE 1: Instalar dependencias PHP (Composer)
# =========================================================================
FROM php:8.4-cli-alpine AS composer_builder

RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    linux-headers \
    $PHPIZE_DEPS \
    && docker-php-ext-install \
        intl \
        zip \
        pdo_pgsql \
        pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./

# Instalar todas las dependencias
RUN composer install --prefer-dist --no-scripts --no-autoloader

# =========================================================================
# STAGE 2: Compilar assets frontend (Vite & Bootstrap)
# =========================================================================
FROM node:22-alpine AS assets_builder

WORKDIR /app

COPY package.json package-lock.json ./
COPY --from=composer_builder /app/vendor/symfony/stimulus-bundle /app/vendor/symfony/stimulus-bundle

RUN npm ci

COPY vite.config.js ./
COPY assets/ ./assets/
COPY public/ ./public/

RUN npm run build

# =========================================================================
# STAGE 3: Imagen Final (PHP 8.4 FPM)
# =========================================================================
FROM php:8.4-fpm-alpine AS app_php

RUN apk add --no-cache \
    icu-data-full \
    icu-libs \
    libzip \
    libpq \
    fcgi \
    su-exec \
    bash \
    git \
    unzip \
    && apk add --no-cache --virtual .build-deps \
        icu-dev \
        libzip-dev \
        postgresql-dev \
        linux-headers \
        $PHPIZE_DEPS \
    && docker-php-ext-install -j$(nproc) \
        intl \
        pdo_pgsql \
        pgsql \
        zip \
        opcache \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY . .

COPY --from=composer_builder /app/vendor/ ./vendor/
COPY --from=assets_builder /app/public/build/ ./public/build/

RUN composer dump-autoload --optimize

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
