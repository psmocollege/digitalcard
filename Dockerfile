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

# --- PERMISSIONS HAVE MOVED ---
# The chown and chmod commands are removed from here.

# Configure Apache
RUN rm /etc/apache2/sites-enabled/000-default.conf
COPY ./docker/apache/drupal.conf /etc/apache2/sites-available/drupal.conf
RUN a2ensite drupal.conf && a2enmod rewrite

# ---- ADD THE ENTRYPOINT SCRIPT ----
# Copy the entrypoint script into the container
COPY docker-entrypoint.sh /usr/local/bin/
# Make the script executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set the entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# The default command to run when the container starts
CMD ["apache2-foreground"]
