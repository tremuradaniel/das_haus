FROM php:8.1-fpm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Add a group and user named "symfony" with GID 1000 and UID 1000
RUN addgroup --gid 1000 symfony && adduser --uid 1000 --gid 1000 --disabled-password --gecos "" --home /home/symfony --shell /bin/sh symfony


# Set ownership and permissions for /var/www/html
RUN chown -R symfony:symfony /var/www/html \
    && chmod -R 775 /var/www/html

USER symfony 

WORKDIR /var/www/html
 
RUN apt-get update

RUN apt-get -y install git zip libpq-dev

COPY backend_api .
 

# Set the PATH to include Symfony CLI
ENV PATH="/home/symfony/.symfony/bin:${PATH}"


# RUN pecl install xdebug

# Expose the port on which Symfony server is running
EXPOSE 8000
