FROM php:8.3-cli

# Instala dependências
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia a aplicação
COPY . .

# Instala dependências do Laravel
#RUN composer install

# Expor porta do artisan serve
EXPOSE 8000

# Comando que vai rodar o servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]