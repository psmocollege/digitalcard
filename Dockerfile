# Use an official PHP 8.3-apache image as the base
FROM php:8.3-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype-dev \
    libwebp-dev \
    zlib1g-dev \
    libicu-dev \
    curl \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_pgsql gd opcache exif intl mbstring zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the entire Drupal project into the container
COPY . /var/www/html

# Run composer install
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Set the correct permissions
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN find /var/www/html -type f -exec chmod 644 {} \;

# Configure Apache
RUN rm /etc/apache2/sites-enabled/000-default.conf
COPY ./docker/apache/drupal.conf /etc/apache2/sites-available/drupal.conf
RUN a2ensite drupal.conf && a2enmod rewrite
