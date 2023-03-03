FROM php:7.4-fpm

# Dockerイメージの作成者情報
LABEL maintainer="tomoki"

# 必要なパッケージのインストール
RUN apt-get update \
  && apt-get install -y \
  git \
  unzip \
  libicu-dev \
  libzip-dev \
  libpq-dev \
  && docker-php-ext-install \
  pdo_mysql \
  pdo_pgsql \
  intl \
  zip \
  && rm -rf /var/lib/apt/lists/*

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Laravel プロジェクトのインストール
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html
COPY backend/composer.json /var/www/html/composer.json
RUN rm -rf /var/www/html/* \
  && git clone https://github.com/laravel/laravel.git backend \
  && git checkout 8.x \
  && composer install --no-scripts --no-autoloader --ignore-platform-reqs --ignore-platform-req=ext-pcntl,nunomaduro/collision


# Laravel のキャッシュの生成
RUN cd /var/www/html \
  && composer dump-autoload \
  && php artisan config:cache

# .env ファイルをコピー
COPY backend/.env.example /var/www/html/.env

# APP_KEY がなければキーを生成
RUN if ! grep -q '^APP_KEY=' /var/www/html/.env; then php artisan key:generate; fi

# laravelユーザを作成
RUN useradd -G www-data,www-data -u 1000 -d /var/www -s /bin/bash laravel \
  && chown -R laravel:www-data /var/www/html

# Laravel のキャッシュの生成とマイグレーションの実行
USER laravel
RUN composer install --no-scripts --optimize-autoloader --no-dev --prefer-dist \
  && php artisan config:cache \
  && php artisan migrate --force

# DocumentRoot の設定
USER root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Apache の設定
RUN a2enmod rewrite