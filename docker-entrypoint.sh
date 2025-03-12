#!/bin/bash
# Espera a que el contenedor MySQL esté listo
echo "Esperando a MySQL..."
while ! mysqladmin ping -hmysql -uroot -p"$DB_PASSWORD" --silent; do
    sleep 2
done

echo "Ejecutando migraciones..."
php artisan migrate --force

echo "Iniciando Vite y Apache..."
npm run dev -- --host 0.0.0.0 --port 5173 --strictPort &

# Ejecuta Apache en primer plano
exec apache2-foreground
