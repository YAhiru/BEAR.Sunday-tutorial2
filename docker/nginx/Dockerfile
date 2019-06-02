FROM nginx:1.15.3-alpine

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000

# Set upstream conf and remove the default conf
RUN echo "" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
