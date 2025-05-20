FROM php:8.1-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libpq-dev

# Очистка кеша
RUN apt clean && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Рабочая директория
WORKDIR /var/www

# Копирование зависимостей
COPY ./driveit/composer.json ./driveit/composer.lock ./

# Установка зависимостей
RUN composer install --no-scripts --no-autoloader --no-interaction

# Копирование всего проекта
COPY ./driveit/ .

# Генерация автозагрузчика
RUN composer dump-autoload --optimize

# Права на запись
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 775 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]

