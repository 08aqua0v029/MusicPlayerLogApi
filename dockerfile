FROM php:8.2-apache

# PHP拡張（MySQL用）
RUN docker-php-ext-install pdo pdo_mysql

# Xdebug を PECL からインストール
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# OPCache 無効化
RUN echo "opcache.enable=0" > /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Python3 + pip
RUN apt-get update && apt-get install -y \
    python3 python3-pip python3-venv \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Xdebug 設定
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# アプリソース
COPY ./src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html