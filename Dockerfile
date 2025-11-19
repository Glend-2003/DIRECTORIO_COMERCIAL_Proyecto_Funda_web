FROM php:8.2-fpm

# Dependencias PHP / Sistema
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg2 ca-certificates supervisor \
    && docker-php-ext-install pdo_mysql zip

# Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
WORKDIR /var/www/html
COPY . .

# Laravel
RUN composer install --no-dev --optimize-autoloader

# Vite
RUN rm -rf node_modules package-lock.json
RUN npm install
RUN npm run build

# Permisos / Cache
RUN chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link
RUN php artisan route:cache

# Instalar Caddy
RUN curl -1sLf https://dl.cloudsmith.io/public/caddy/stable/gpg.key \
    -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg

RUN curl -1sLf https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt \
    | tee /etc/apt/sources.list.d/caddy.list

RUN apt-get update && apt-get install -y caddy

# Supervisor (controla PHP-FPM + Caddy)
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
