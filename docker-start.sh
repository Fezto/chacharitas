#!/bin/bash

# Esperar a MySQL
echo "Esperando a MySQL..."
while ! mysqladmin ping -hmysql -uroot -p"$DB_PASSWORD" --silent; do
    sleep 2
done

# Configurar permisos
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 storage bootstrap/cache

# Iniciar PHP-FPM en segundo plano
php-fpm -D

# Configurar entorno para Vite
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Iniciar servicios
echo "Iniciando Nginx y Vite..."
npm run dev -- --host 0.0.0.0 --port 5173 --strictPort &
nginx -g 'daemon off;'
