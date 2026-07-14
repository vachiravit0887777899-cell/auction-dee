# Stage 1: Build frontend assets
FROM node:20-alpine AS node_build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP application
FROM php:8.3-cli

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