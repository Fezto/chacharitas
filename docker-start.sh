#!/bin/bash

# Esperar a MySQL
echo "Esperando a MySQL..."
while ! mysqladmin ping -hmysql -uroot -p"$DB_PASSWORD" --silent; do
    sleep 2
done

# Ejecutar migraciones
echo "Ejecutando migraciones..."

# Iniciar servicios
echo "Iniciando Vite y Apache..."
npm run dev -- --host 0.0.0.0 --port 5173 --strictPort &
apache2-foreground
