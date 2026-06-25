# PHP + Apache image for the Journal web app.
FROM php:8.2-apache

# MySQL driver for PDO + URL rewriting for the front controller (.htaccess).
RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

# Allow the project's .htaccess (RewriteRule -> index.php) to take effect.
RUN sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Keep PHP notices/deprecations out of the HTTP response (older app + PHP 8.2).
COPY docker/php.ini /usr/local/etc/php/conf.d/zzz-app.ini

# The application code is bind-mounted to /var/www/html via docker-compose,
# which is already Apache's default DocumentRoot.
EXPOSE 80
