FROM php:7.4-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy custom php.ini
COPY php/config/php.ini /usr/local/etc/php/

# Set working directory
WORKDIR /var/www/html

# Copy application source
COPY html/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
