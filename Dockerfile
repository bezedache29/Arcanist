FROM php:8.2-apache

# Installation des extensions PDO pour MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Activation du module de réécriture pour les routes d'Arcane
RUN a2enmod rewrite

# On définit le répertoire de travail
WORKDIR /var/www/html

# Ajustement des permissions pour le serveur web
RUN chown -R www-data:www-data /var/www/html