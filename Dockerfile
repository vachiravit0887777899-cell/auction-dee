# Stage 1: Build frontend assets
FROM node:20-alpine AS node_build
WORKDIR /app

ENV VITE_PUSHER_APP_KEY=fcc4e23ce4ca4b8545a9
ENV VITE_PUSHER_HOST=
ENV VITE_PUSHER_PORT=443
ENV VITE_PUSHER_SCHEME=https
ENV VITE_PUSHER_APP_CLUSTER=ap1

COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP application
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo_pgsql pgsql mbstring bcmath zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
COPY --from=node_build /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan storage:link --force; \
    php artisan migrate --force; \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}