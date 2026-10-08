#!/bin/sh
set -e

if [ ! "$(ls -A /var/www/vendor)" ]; then
  echo "Initializing vendor directory..."
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist
fi

if [ ! "$(ls -A /var/www/node_modules)" ]; then
  echo "Initializing node_modules directory..."
  npm install && npm run build
fi

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
# if [ ! "$(ls -A /var/www/storage 2>/dev/null)" ]; then
#   echo "Initializing storage directory..."
#   cp -R /opt/storage-init /var/www/storage
# fi

# Remove storage-init directory
# rm -rf /var/www/storage-init

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
# php artisan migrate --force

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:clear
php artisan route:clear

# Run the default command
exec "$@"
