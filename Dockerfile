FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libpq-dev libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install \
    && npm run build

EXPOSE 10000

CMD php artisan migrate --force; php artisan db:seed --force; php artisan storage:link; php artisan serve --host=0.0.0.0 --port=${PORT:-10000}