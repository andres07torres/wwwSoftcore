#!/bin/sh
set -e

# Crear carpetas de runtime de Symfony si no existen
mkdir -p /var/www/html/var/cache /var/www/html/var/log /var/www/html/public

# Sincronizar siempre el build de Vite recién compilado hacia el volumen montado public/build
if [ -f /var/www/public_build/.vite/entrypoints.json ]; then
    echo "Sincronizando assets de Vite compilados hacia public/build..."
    rm -rf /var/www/html/public/build
    mkdir -p /var/www/html/public/build
    cp -r /var/www/public_build/. /var/www/html/public/build/ 2>/dev/null || true
fi

# Ajustar permisos para www-data
chown -R www-data:www-data /var/www/html/var /var/www/html/public 2>/dev/null || true
chmod -R 775 /var/www/html/var /var/www/html/public 2>/dev/null || true

# Ejecutar el comando del contenedor (php-fpm)
exec "$@"
