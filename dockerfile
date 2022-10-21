FROM nginx:latest

COPY config/nginx.conf /etc/nginx/conf.d/nginx.conf
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

COPY . .
RUN composer dump-autoload

CMD ["nginx", "-g", "daemon off;"]

EXPOSE 80
