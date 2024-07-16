# Use the official PHP 8 image
FROM php:8.0.29-apache
 
# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        curl \
        nano
 
# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl bcmath xml
 
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
 
# Set working directory
WORKDIR /var/www/html
 
# Copy Laravel files
COPY . .
 
# Install Laravel dependencies
#3# RUN composer install --no-interaction --prefer-dist --optimize-autoloader
#3# RUN composer install --no-interaction --prefer-dist
RUN composer install
 
# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
 
# Expose port 8000
EXPOSE 8000

VOLUME /var/www/html/public/storage
VOLUME /var/www/html/storage/app/public
 
# Start PHP server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
