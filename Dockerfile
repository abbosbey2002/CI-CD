# PHP bilan bazaviy image
FROM php:8.2-fpm

# Kerakli kutubxonalarni o‘rnatish
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# Composer qo‘shish
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ishchi katalog
WORKDIR /var/www

# Laravel loyihasini yuklash
COPY . .

# `.env` faylini nusxalash
COPY .env.example .env

# Composer install qilish
RUN composer install --no-dev --optimize-autoloader

# Laravel uchun ruxsatlarni sozlash
RUN chmod -R 775 storage bootstrap/cache

# PHP-FPM ishga tushirish
CMD ["php-fpm"]
