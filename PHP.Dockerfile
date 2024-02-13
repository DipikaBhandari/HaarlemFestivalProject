FROM php:fpm

RUN apt-get update && apt-get install -y \
        gnupg \
        unixodbc-dev \
        g++ \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zlib1g-dev \
        libzip-dev \
        && docker-php-ext-install pdo pdo_mysql mysqli gd zip

RUN apt-get install -y \
        libonig-dev \
        libxml2-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer require phpmailer/phpmailer

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
        msodbcsql17 \
        mssql-tools \
        unixodbc \
    && pecl install pdo_sqlsrv sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv \
    && apt-get clean && rm -rf /var/lib/apt/lists/*