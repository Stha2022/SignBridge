FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite headers

COPY public/ /var/www/html/
COPY api/ /var/www/api/

RUN printf '%s\n' \
    'Alias /api/ /var/www/api/' \
    '<Directory /var/www/api/>' \
    '    Options -Indexes' \
    '    AllowOverride None' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/signbridge-api.conf \
    && a2enconf signbridge-api

RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    '    DocumentRoot /var/www/html' \
    '    <Directory /var/www/html>' \
    '        AllowOverride All' \
    '        Require all granted' \
    '    </Directory>' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf

EXPOSE 80
