FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
	procps \
	wget \
	zip \
	git \
	libmcrypt-dev \
	build-essential \
	libxml2-dev \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libxrender1 \
	libfontconfig \
	apt-transport-https

RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash

RUN apt install symfony-cli

RUN	docker-php-ext-install pdo_mysql soap mysqli pcntl

ENV NODE_VERSION=16.13.0
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
