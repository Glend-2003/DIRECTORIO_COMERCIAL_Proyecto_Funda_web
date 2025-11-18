# ---- Imagen de PHP + Composer + extensiones necesarias ----
FROM php:8.2-fpm

# Instalar extensiones requeridas por Laravel + MySQL
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código
WORKDIR /var/www/html
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos de Laravel
RUN chmod -R 775 storage bootstrap/cache

# Generar cachés de Laravel
RUN php artisan config:cache
RUN php artisan route:cache

# Ejecutar servidor
CMD php artisan serve --host=0.0.0.0 --port=$PORT
