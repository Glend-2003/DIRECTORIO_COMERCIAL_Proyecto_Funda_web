# ---- Imagen PHP con extensiones necesarias ----
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg \
    && docker-php-ext-install pdo_mysql zip

# Instalar Node.js 18 (compatible con Laravel + Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
WORKDIR /var/www/html
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node
RUN npm install

# Build de Vite
RUN npm run build

# Crear enlace de storage
RUN php artisan storage:link

# Permisos de Laravel
RUN chmod -R 775 storage bootstrap/cache

# Caches Laravel
RUN php artisan config:cache
RUN php artisan route:cache

# Exponer puerto
EXPOSE 8000

# Comando para iniciar Laravel en Render
CMD php artisan serve --host=0.0.0.0 --port=$PORT
