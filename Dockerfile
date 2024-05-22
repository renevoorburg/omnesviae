FROM composer:latest as builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist


FROM php:8.3-fpm
RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

COPY ./config/nginx/default /etc/nginx/sites-available/default
COPY ./config/nginx/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

COPY . /var/www
COPY --from=builder /app/vendor /var/www/vendor

RUN chown -R www-data:www-data /var/www

EXPOSE 80
CMD service nginx start && php-fpm
