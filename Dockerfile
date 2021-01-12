FROM php:7.2-apache
RUN a2enmod rewrite
COPY . /var/www/html/.
RUN chmod -R 777 /var/www/html/users.db
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]