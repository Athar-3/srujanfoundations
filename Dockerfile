# Use official PHP image
FROM php:8.0-apache

# Install dependencies
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html/

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
