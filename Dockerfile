FROM php:8.2-apache

# Install system dependencies & PHP extensions for CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_mysql mysqli gd zip

# Enable Apache mod_rewrite for CI4 routing
RUN a2enmod rewrite

# Configure Apache DocumentRoot to point to CI4's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set writable directory permissions for CI4
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80

CMD ["apache2-foreground"]
