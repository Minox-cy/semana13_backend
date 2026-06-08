FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar módulos de Apache
RUN a2enmod rewrite headers

# Copiar tu código al contenedor
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
