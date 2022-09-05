ARG PHP_VERSION=8.1
ARG COMPOSER_VERSION=2.4.1

###########################################
# PHP dependencies
###########################################

FROM composer:${COMPOSER_VERSION} AS vendor

WORKDIR /var/www/html

COPY ./src/composer* ./

RUN composer install \
  --no-dev \
  --no-interaction \
  --prefer-dist \
  --ignore-platform-reqs \
  --optimize-autoloader \
  --apcu-autoloader \
  --ansi \
  --no-scripts \
  --audit

###########################################
# Application
###########################################

FROM php:${PHP_VERSION}-cli-buster

# Prepend pipfail
SHELL ["/bin/bash", "-o", "pipefail", "-c"]

# Install dependencies
RUN set -ex \
    && RUN_DEPS=" \
        iproute2 \
        unzip \
        libzip4 \
        libonig5 \
        libpng16-16 \
        libicu63 \
    " \
    && seq 1 8 | xargs -I{} mkdir -p /usr/share/man/man{} \
    && apt-get update && apt-get install -y --no-install-recommends $RUN_DEPS \
    && rm -rf /var/lib/apt/lists/*

RUN set -ex \
    && BUILD_DEPS=" \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libicu-dev \
    " \
    && BUILD_MODULES=" \
        bcmath \
        pdo_mysql \
        zip \
        mbstring \
        exif \
        intl \
    " \
    && apt-get update && apt-get install -y --no-install-recommends $BUILD_DEPS \
    && docker-php-ext-install $BUILD_MODULES \
    \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false $BUILD_DEPS \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && php -m

# Install PHP extension gd
RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

# Install swoole
RUN pecl install swoole \
    && docker-php-ext-enable swoole

# Install kafka
RUN apt-get install -yqq --no-install-recommends --show-progress librdkafka-dev \
      && pecl -q install -o -f rdkafka \
      && docker-php-ext-enable rdkafka

RUN docker-php-source delete

# Add user for laravel application
RUN adduser \
        --disabled-password \
        --shell "/sbin/nologin" \
        --no-create-home \
        --uid "10001" \
        --gecos "" \
        "app_user" \
    && chown -R app_user:app_user /var/www/html

WORKDIR /var/www/html

# Change current user to www
USER app_user:app_user

COPY --chown=app_user:app_user ./src .
COPY --from=vendor --chown=app_user:app_user /var/www/html/vendor vendor

RUN cp .env.example .env

ENV APP_ENV="production"
ENV APP_KEY="base64:HVXQNIfAy8Deaj2b0bvTjwBCFvxTjCyK+pA60tRyDTs="
ENV APP_DEBUG=false

RUN php artisan optimize

# Expose port 9000
EXPOSE 9000

CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--workers=4", "--port=9000", "--max-requests=500"]
