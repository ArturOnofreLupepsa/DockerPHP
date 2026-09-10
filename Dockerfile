FROM php:8.4-apache

# Instala a extensão pdo_mysql, necessária para o PHP conseguir
# se conectar ao MySQL/MariaDB usando PDO (usado no db.php)
RUN docker-php-ext-install pdo pdo_mysql