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

# Ajustar permisos solo para var (runtime de Symfony) sin apropiarse de public/ en el host
chown -R www-data:www-data /var/www/html/var 2>/dev/null || true
chmod -R 775 /var/www/html/var 2>/dev/null || true
chmod -R a+rX /var/www/html/public/build 2>/dev/null || true

# Al iniciar php-fpm, regenerar caché de Symfony y aplicar migraciones pendientes
if [ "$1" = "php-fpm" ]; then
    echo "Limpiando y regenerando caché de Symfony..."
    su-exec www-data php bin/console cache:clear --no-interaction

    echo "Ejecutando migraciones de base de datos..."
    su-exec www-data php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
fi

# Ejecutar el comando del contenedor (php-fpm)
exec "$@"
