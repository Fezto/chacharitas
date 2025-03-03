# Usa una imagen base con PHP y Apache
FROM php:8.4-apache

# Instala Node.js desde NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libicu-dev \
    zip git unzip default-mysql-client && \
    apt-get clean

# Configura extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_mysql gd bcmath intl zip

# Habilita módulos de Apache y configura ServerName
RUN a2enmod rewrite headers && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configuración de Xdebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuración de Apache para Laravel
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . .

# Instala dependencias y construye assets
RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    npm cache clean --force && \
    npm install --force --legacy-peer-deps && \
    npm run build && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    composer update && \
    npm update

# Puerto para Vite
EXPOSE 80 5173

# Script de inicio
COPY docker-start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-start.sh
CMD ["docker-start.sh"]
