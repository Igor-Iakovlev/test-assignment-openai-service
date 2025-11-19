FROM php:8.3-apache

RUN a2enmod rewrite

RUN apt-get update \
    && apt-get install -y \
    curl \
    libzip-dev \
    libcurl4-openssl-dev \
    unzip \
    git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install zip curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .
RUN if [ -f composer.json ]; then \
      echo "Installing Composer dependencies..." && \
      composer install --no-dev --optimize-autoloader --no-scripts && \
      echo "Composer install complete. Vendor size:" && ls -la vendor/autoload.php || echo "Autoload not found!"; \
    else \
      echo "No composer.json found!"; \
    fi

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
