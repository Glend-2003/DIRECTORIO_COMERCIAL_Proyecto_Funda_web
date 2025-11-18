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
# Cache routes
# -----------------------------------------
RUN php artisan route:cache

# -----------------------------------------
# Install Caddy (Official Debian Repo)
# -----------------------------------------
RUN apt-get update && apt-get install -y curl gnupg2 ca-certificates

# Add GPG key
RUN curl -1sLf https://dl.cloudsmith.io/public/caddy/stable/gpg.key \
    -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg

# Add repo
RUN curl -1sLf https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt \
    | tee /etc/apt/sources.list.d/caddy.list

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
