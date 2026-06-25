FROM node:24-alpine AS assets

WORKDIR /var/www

COPY ./laravel/package*.json ./
RUN npm ci

COPY ./laravel ./
RUN npm run build

FROM php:8.5-fpm AS builder

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install -j"$(nproc)" \
    pdo_pgsql \
    pgsql \
    intl \
    zip \
    bcmath \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www

COPY ./laravel /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

FROM php:8.5-fpm AS production

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libfcgi-bin \
    postgresql-client \
    procps \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -fsSL -o /usr/local/bin/php-fpm-healthcheck \
    https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck \
    && chmod +x /usr/local/bin/php-fpm-healthcheck

COPY ./php-fpm/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

COPY ./laravel/storage /var/www/storage-init
COPY ./laravel/public/images/products /var/www/product-images-init

COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /var/www /var/www
COPY --from=assets /var/www/public/build /var/www/public/build

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY ./php-fpm/conf.d/*.conf /usr/local/etc/php-fpm.d/

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]
