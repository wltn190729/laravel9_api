FROM nginx:latest

COPY config/nginx.conf /etc/nginx/conf.d/nginx.conf

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
