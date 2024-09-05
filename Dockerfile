# Use the official PHP-FPM image
FROM php:8.1-fpm

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && apt-get install -y curl

# Set working directory
WORKDIR /var/www/html

# Copy application code to the container
COPY . /var/www/html

# Set file permissions (if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose port 9000 for PHP-FPM
EXPOSE 9000