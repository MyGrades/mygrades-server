FROM php:7.1-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        curl-dev \
        imagemagick-dev \
        libtool \
        libxml2-dev \
    && apk add --no-cache \
        curl \
        git \
        imagemagick \
        mysql-client \
        libintl \
        icu \
        icu-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install \
        curl \
        iconv \
        mbstring \
        pdo \
        pdo_mysql \
        pcntl \
        tokenizer \
        xml \
        zip \
        intl

# install composer
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
    && apk del -f .build-deps

# install phpunit
RUN curl https://phar.phpunit.de/phpunit.phar -L > phpunit.phar \
  && chmod +x phpunit.phar \
  && mv phpunit.phar /usr/local/bin/phpunit \
  && phpunit --version
