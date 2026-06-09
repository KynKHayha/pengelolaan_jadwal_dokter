FROM php:8.2-apache

# 1. Install dependensi sistem dan ekstensi PHP untuk Laravel
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 2. Aktifkan mod_rewrite Apache (wajib untuk routing Laravel)
RUN a2enmod rewrite

# 3. Ubah Document Root Apache agar mengarah ke folder /public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Copy semua file project Laravel ke dalam server
COPY . /var/www/html

# 5. Set folder kerja utama
WORKDIR /var/www/html

# 6. Install Composer & jalankan instalasi dependensi Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 7. Berikan akses/permission agar Laravel bisa menulis file (upload/cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Buka port 80 untuk akses web
EXPOSE 80