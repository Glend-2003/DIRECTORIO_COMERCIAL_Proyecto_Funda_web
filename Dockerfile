FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl \
    supervisor \
    && docker-php-ext-install pdo_mysql zip

# Instalar NodeJS
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Caddy (repos correctos)
RUN apt-get install -y debian-keyring debian-archive-keyring apt-transport-https \
    && curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' \
        -o /usr/share/keyrings/caddy.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/caddy.gpg] https://dl.cloudsmith.io/public/caddy/stable/deb/debian any-version main" \
        > /etc/apt/sources.list.d/caddy.list \
    && apt-get update \
    && apt-get install -y caddy

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Crear .env
RUN cp .env.example .env \
    && sed -i "s/APP_ENV=.*/APP_ENV=production/" .env.example \
    && sed -i "s/APP_DEBUG=.*/APP_DEBUG=false/" .env.example

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Generar KEY (NO USAR VARIABLE DE RAILWAY)
RUN php artisan key:generate --force

# Build de assets
RUN rm -rf node_modules package-lock.json \
    && npm install \
    && npm run build

# Permisos Laravel
RUN chmod -R 775 storage bootstrap/cache \
    && php artisan storage:link \
    && php artisan route:cache

# Supervisord + Caddy config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80

CMD ["supervisord", "-n"]
