# Define a imagem base do PHP
FROM php:8.1-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Instala extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o código-fonte do Laravel para o diretório de trabalho
COPY . /var/www/html

# Define as permissões adequadas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Executa o comando composer install
RUN composer install --no-interaction --optimize-autoloader

# Exponha a porta 9000 para o Nginx
EXPOSE 9000

# Comando padrão para iniciar o servidor PHP-FPM
CMD ["php-fpm"]
