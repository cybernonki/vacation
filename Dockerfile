FROM ubuntu:22.04
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN ln -s libX11.so.6 /usr/lib32/libX11.so
RUN ln -s libXTrap.so.6 /usr/lib32/libXTrap.so
RUN ln -s libXt.so.6 /usr/lib32/libXt.so
RUN ln -s libXtst.so.6 /usr/lib32/libXtst.so
RUN ln -s libXmu.so.6 /usr/lib32/libXmu.so
RUN ln -s libXext.so.6 /usr/lib32/libXext.so 


RUN apt update \
  && apt install -y \
  software-properties-common \
  && add-apt-repository ppa:ondrej/php \
  && apt install -y language-pack-ja-base language-pack-ja
RUN apt update \
  && apt install -y \
  vim \
  less \
  zip \
  apache2 \
  unzip \
  curl \
  git \
  mysql-client \
  php8.3 \
  php8.3-cli \
  php8.3-intl \
  php8.3-mbstring \
  php8.3-common \
  php8.3-gd \
  php8.3-mysql \
  php8.3-xml \
  php8.3-zip \
  php8.3-dom \
  php8.3-curl

RUN a2enmod ssl
RUN a2ensite default-ssl

# apache2
COPY apache/000-default.conf /etc/apache2/sites-available/
COPY apache/default-ssl.conf /etc/apache2/sites-available/
RUN a2enmod rewrite
# php
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

# node
RUN apt install -y nodejs npm
RUN npm install -n -g
RUN n stable
RUN apt purge -y nodejs npm
RUN npm update -g npm

WORKDIR /var/www/html

SHELL [ "/bin/bash", "-c" ]
CMD ["apachectl", "-D", "FOREGROUND"]
