#!/bin/sh
set -e

# Crear carpetas de runtime de Symfony si no existen
mkdir -p /var/www/html/var/cache /var/www/html/var/log /var/www/html/public

# Ajustar permisos para www-data
chown -R www-data:www-data /var/www/html/var /var/www/html/public 2>/dev/null || true
chmod -R 775 /var/www/html/var /var/www/html/public 2>/dev/null || true

# Ejecutar el comando del contenedor (php-fpm)
exec "$@"
