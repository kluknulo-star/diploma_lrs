## Определяем базовый образ, который мы используем
FROM php:8.1.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

ENV uid=${uid:-0129915}
ENV user=${user:-victor}


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# мы установим Composer,
# скопировав исполняемый файл composer
# из последнего официального образа в образ нашего приложения.

#Инструкция RUN выполняет любые команды в новом слое поверх текущего образа и делает коммит результата.
# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

#RUN ["php artisan migrate"]
#RUN php-artisan migrate
#RUN docker-exec-php-artisan migrate
# почему не работает ран
USER $user
