#!/bin/sh
set -e

if [ ! "$(ls -A /var/www/storage 2>/dev/null)" ]; then
  echo "Initializing Laravel storage volume..."
  cp -R /var/www/storage-init/. /var/www/storage
fi

if [ ! "$(ls -A /var/www/public/images/products 2>/dev/null)" ]; then
  echo "Initializing product images volume..."
  cp -R /var/www/product-images-init/. /var/www/public/images/products
fi

chown -R www-data:www-data /var/www/storage /var/www/public/images/products
rm -rf /var/www/storage-init /var/www/product-images-init

php artisan config:clear
php artisan route:clear

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  php artisan migrate --force
fi

if [ "${RUN_SEEDER:-true}" = "true" ]; then
  PRODUCT_COUNT="$(PGPASSWORD="${DB_PASSWORD}" psql -h "${DB_HOST:-postgres}" -p "${DB_PORT:-5432}" -U "${DB_USERNAME}" -d "${DB_DATABASE}" -tAc "SELECT COUNT(*) FROM products;" 2>/dev/null || echo 0)"
  PRODUCT_COUNT="$(echo "${PRODUCT_COUNT}" | tr -d '[:space:]')"

  if [ "${PRODUCT_COUNT:-0}" = "0" ]; then
    php artisan db:seed --force
  fi
fi

exec "$@"
