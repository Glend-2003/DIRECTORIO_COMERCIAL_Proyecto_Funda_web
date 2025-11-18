# -----------------------------------------
# Imagen base de PHP con extensiones
# -----------------------------------------
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg \
    && docker-php-ext-install pdo_mysql zip

# -----------------------------------------
# Instalar Node.js 20 (requerido por Vite 7)
# -----------------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# -----------------------------------------
# Instalar Composer
# -----------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -----------------------------------------
# Copiar proyecto
# -----------------------------------------
WORKDIR /var/www/html
COPY . .

# -----------------------------------------
# Instalar dependencias de PHP
# -----------------------------------------
RUN composer install --no-dev --optimize-autoloader

# -----------------------------------------
# Instalar dependencias de Node
# -----------------------------------------
RUN rm -rf node_modules package-lock.json
RUN npm install

# -----------------------------------------
# Compilar assets con Vite
# -----------------------------------------
RUN npm run build

# -----------------------------------------
# Configuración de Laravel
# -----------------------------------------
RUN php artisan storage:link
RUN chmod -R 775 storage bootstrap/cache

RUN php artisan config:cache
RUN php artisan route:cache

# -----------------------------------------
# Exponer puerto y ejecutar app
# -----------------------------------------
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=$PORT
