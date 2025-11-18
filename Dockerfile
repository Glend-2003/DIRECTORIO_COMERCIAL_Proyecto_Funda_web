# -----------------------------------------
# Imagen base PHP con extensiones
# -----------------------------------------
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg \
    && docker-php-ext-install pdo_mysql zip

# -----------------------------------------
# Instalar Node.js 20
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
# Instalación Laravel
# -----------------------------------------
RUN composer install --no-dev --optimize-autoloader

# -----------------------------------------
# Build de Vite
# -----------------------------------------
RUN rm -rf node_modules package-lock.json
RUN npm install
RUN npm run build

# -----------------------------------------
# Permisos y Storage
# -----------------------------------------
RUN chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link

# -----------------------------------------
# Cache SOLO de rutas (no config)
# -----------------------------------------
RUN php artisan route:cache

# -----------------------------------------
# Instalar Caddy
# -----------------------------------------
RUN apt-get install -y debian-keyring debian-archive-keyring apt-transport-https
RUN curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | apt-key add -
RUN curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-stable.list
RUN apt-get update && apt-get install -y caddy

# -----------------------------------------
# Copiar Caddyfile
# -----------------------------------------
COPY Caddyfile /etc/caddy/Caddyfile

# -----------------------------------------
# Exponer puerto y ejecutar
# -----------------------------------------
EXPOSE 80
CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile"]
