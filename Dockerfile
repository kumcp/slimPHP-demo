FROM php:7-alpine


COPY . /var/www

WORKDIR /var/www

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]