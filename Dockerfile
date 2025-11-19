FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg \
    && docker-php-ext-install pdo_mysql zip

# Node 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Crear .env
COPY .env.example .env
RUN sed -i "s/APP_ENV=.*/APP_ENV=production/" .env
RUN sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env

# -----------------------------------------
# INSTALAR DEPENDENCIAS LARAVEL **ANTES** DE ARTISAN
# -----------------------------------------
RUN composer install --no-dev --optimize-autoloader

# AHORA sí se puede ejecutar artisan
RUN php artisan key:generate --force

# Build de Vite
RUN rm -rf node_modules package-lock.json
RUN npm install
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link
RUN php artisan route:cache

# Caddy
# -----------------------------------------
# Instalar Caddy sin que falle el repo
# -----------------------------------------
RUN apt-get update && apt-get install -y curl

# Importar clave
RUN curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' \
    | gpg --dearmor -o /usr/share/keyrings/caddy.gpg

# Agregar repo correctamente
RUN echo "deb [signed-by=/usr/share/keyrings/caddy.gpg] \
https://dl.cloudsmith.io/public/caddy/stable/deb/debian any-version main" \
    > /etc/apt/sources.list.d/caddy.list

# Instalar Caddy
RUN apt-get update && apt-get install -y caddy

COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80
CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile"]
