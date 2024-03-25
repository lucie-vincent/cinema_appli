#  on précise l'image apache que l'on utilise
FROM php:8.2-apache

#  on précise les extensions php à installer/ activer
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

#  on précise le port d'apache : 80
EXPOSE 80
