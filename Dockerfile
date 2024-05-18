FROM php:8.0-fpm
RUN apt-get update && apt-get install -y nginx

COPY ./config/nginx/default /etc/nginx/sites-available/default
COPY ./config/nginx/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

COPY . /var/www
RUN chown -R www-data:www-data /var/www

EXPOSE 80
CMD service nginx start && php-fpm
#CMD ["tail", "-f", "/dev/null"]