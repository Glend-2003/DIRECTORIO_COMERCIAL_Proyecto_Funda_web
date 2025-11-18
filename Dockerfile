# ---- Imagen de PHP + Composer ----
FROM php:8.2-fpm

# Instalar dependencias de sistema
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg \
    && docker-php-ext-install pdo_mysql zip

# Instalar Node.js 18 (Vite requiere Node)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código
WORKDIR /var/www/html
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias JS
RUN npm ci

# Compilar Vite (modo producción)
RUN npm run build

# Permisos
RUN chmod -R 775 storage bootstrap/cache

# Cachés Laravel
RUN php artisan config:cache
RUN php artisan route:cache

# Iniciar Laravel (Render usa port $PORT)
CMD php artisan serve --host=0.0.0.0 --port=$PORT
