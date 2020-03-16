FROM php:7.2-fpm

RUN mkdir ~/.ssh
RUN echo 'Host github.com\n\
            StrictHostKeyChecking no\n\
            IdentityFile ~/.ssh-local/id_rsa' > ~/.ssh/config

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip


WORKDIR /usr/src/app
RUN usermod -u 1001 www-data

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
