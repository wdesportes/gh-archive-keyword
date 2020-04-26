#!/bin/sh

set -e

cd /var/www/html
if [ ! -f vendor/autoload.php ]; then
    echo 'Installing vendor files'
    composer update --no-suggest --no-interaction --optimize-autoloader
fi

echo 'Starting php fpm'
php-fpm7 --allow-to-run-as-root --daemonize

echo 'Set file and folders permissions'
chmod 777 -R /var/www/html/storage/logs
chmod 777 -R /var/www/html/storage/framework

cd /var/www/html/public
echo 'Running nginx...'
nginx -g 'daemon off;';
