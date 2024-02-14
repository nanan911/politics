#!/bin/bash

chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

exec php-fpm
