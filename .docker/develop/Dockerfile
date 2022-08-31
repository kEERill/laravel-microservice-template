FROM php:8.1-fpm-buster

ENV COMPOSER_MEMORY_LIMIT='-1'

COPY --from=composer:2.4.1  /usr/bin/composer /usr/bin/composer

ENV COMPOSER_HOME="/tmp/composer"

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

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
