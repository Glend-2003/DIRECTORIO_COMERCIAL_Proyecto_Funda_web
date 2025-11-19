FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl gnupg2 ca-certificates supervisor \
    && docker-php-ext-install pdo_mysql zip

# Node 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN rm -rf node_modules package-lock.json
RUN npm install
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link
RUN php artisan route:cache

# --- FIX SOCKET PHP-FPM ---
RUN sed -i "s|listen = .*|listen = /run/php/php-fpm.sock|" /usr/local/etc/php-fpm.d/www.conf
RUN mkdir -p /run/php

# Caddy install
RUN curl -1sLf https://dl.cloudsmith.io/public/caddy/stable/gpg.key \
    -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg

RUN curl -1sLf https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt \
    | sed -e 's#deb #deb [signed-by=/usr/share/keyrings/caddy-stable-archive-keyring.gpg] #' \
    | tee /etc/apt/sources.list.d/caddy-stable.list

RUN apt-get update && apt-get install -y caddy

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80
CMD ["supervisord", "-n"]
