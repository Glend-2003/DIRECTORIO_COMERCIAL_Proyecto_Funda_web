FROM php:8.2-fpm

# Dependencias
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl supervisor \
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

# ------- FIX PHP-FPM SOCKET -------
RUN sed -i "s|listen = .*|listen = /run/php/php-fpm.sock|" /usr/local/etc/php-fpm.d/www.conf
RUN mkdir -p /run/php

# ------- INSTALAR CADDY SIN REPOS ----------------
RUN curl -L -o caddy.deb "https://github.com/caddyserver/caddy/releases/download/v2.7.6/caddy_2.7.6_linux_amd64.deb" \
    && dpkg -i caddy.deb \
    && rm caddy.deb

# Copiar configs
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 80
CMD ["supervisord", "-n"]
