FROM php:8.2-apache-bookworm
RUN sed -i 's|http://deb.debian.org|https://deb.debian.org|g' /etc/apt/sources.list.d/debian.sources \
    && apt-get update && apt-get install -y --no-install-recommends \
    libonig-dev libxml2-dev libcurl4-openssl-dev dnsutils \
    && docker-php-ext-install mysqli mbstring soap curl \
    && rm -rf /var/lib/apt/lists/*
COPY src/ /var/www/html/
COPY docker/lab.conf /etc/apache2/conf-enabled/group-lab.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/group-lab.ini
COPY scripts/seed.php /opt/group/seed.php
COPY tests/ /opt/group/tests/
WORKDIR /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;
