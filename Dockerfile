# Use official PHP image with Apache
FROM php:8.0-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . /var/www/html/

# Set Apache permissions
RUN chown -R www-data:www-data /var/www/html

# Restart Apache to apply changes
CMD ["apache2-foreground"]
