FROM node:24-alpine AS assets

WORKDIR /var/www

COPY ./laravel/package*.json ./
RUN npm ci

COPY ./laravel ./
RUN npm run build

FROM nginx:alpine

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY --from=assets /var/www/public /var/www/public

WORKDIR /var/www/public

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
