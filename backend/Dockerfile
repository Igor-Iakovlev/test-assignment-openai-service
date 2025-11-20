FROM php:8.3-apache

ARG PHP_ENV

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
    && rm -rf /var/lib/apt/lists/*;

WORKDIR /var/www/html
COPY . .

RUN if [ "$PHP_ENV" = "development" ]; then \
        composer install --optimize-autoloader --no-scripts; \
    else \
        composer install --no-dev --optimize-autoloader --no-scripts && \
        rm -f composer.json composer.lock; \
    fi

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
