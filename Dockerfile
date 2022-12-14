FROM php:8.1-fpm

ARG user
ARG uid

#의존성 설치
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get -qq install nodejs --yes

#캐시 클리어
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#php 확장 설치
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

##마지막 컴포저 버전
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

#CMD bash -c "npm install"

WORKDIR /var/www/html

USER $user
