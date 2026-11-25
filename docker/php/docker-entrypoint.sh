#!/bin/sh
set -e

# Crear carpetas de runtime de Symfony si no existen
mkdir -p /var/www/html/var/cache /var/www/html/var/log /var/www/html/public

# Sincronizar automáticamente el build de Vite hacia public si no existe en el volumen montado
if [ ! -f /var/www/html/public/build/.vite/entrypoints.json ]; then
    echo "Sincronizando assets de Vite compilados hacia public..."
    mkdir -p /var/www/html/public/build
    cp -r /var/www/public_build/* /var/www/html/public/build/ 2>/dev/null || true
fi

# Ajustar permisos para www-data
chown -R www-data:www-data /var/www/html/var /var/www/html/public 2>/dev/null || true
chmod -R 775 /var/www/html/var /var/www/html/public 2>/dev/null || true

# Ejecutar el comando del contenedor (php-fpm)
exec "$@"
