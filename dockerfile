# PHP + Apache イメージ（Debianベース）
FROM php:8.2-apache

# PHP拡張をインストール（MySQL接続用）
RUN docker-php-ext-install pdo pdo_mysql

# Python環境のセットアップ（distutils含む）
RUN apt-get update && apt-get install -y \
    python3 \
    python3-pip \
    python3-distutils \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Apacheの公開ディレクトリに src/ をコピー
COPY ./src/ /var/www/html/

# オーナー権限の調整（必要に応じて）
RUN chown -R www-data:www-data /var/www/html