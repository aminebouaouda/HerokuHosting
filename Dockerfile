# Use the official PHP image with Apache
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Copy the Laravel project files
COPY . .

# Ensure the /upload/images directory exists and set permissions
RUN mkdir -p public/upload/images && chmod -R 775 public/upload/images

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --timeout=600


# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
