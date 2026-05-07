FROM php:8.4-cli

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev

# Extensiones PHP
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip \
    intl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Permitir composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app

# Copiar composer primero para cache Docker
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install \
    --no-dev \
    --no-scripts \
    --optimize-autoloader \
    --no-interaction

# Copiar resto del proyecto
COPY . .

# Permisos
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080