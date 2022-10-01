FROM php:8.1-fpm-alpine

RUN apk add oniguruma-dev

RUN apk add git \
    freetype-dev \
    libpq-dev \
    libzip-dev \
    zlib-dev \
    libxpm-dev \
    postgresql-client

# Install PHP extensions
RUN docker-php-ext-install gd \
    pdo_pgsql \
    mbstring \
    exif \
    zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www
