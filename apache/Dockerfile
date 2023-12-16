FROM ubuntu:22.04
ARG DEBIAN_FRONTEND=noninteractive
USER root
RUN set -ex \
    && apt-get -q update \
    && apt-get -q -y install --no-install-recommends \
        tzdata ca-certificates curl apache2 libapache2-mod-security2 \
    && rm -rf /var/lib/apt/lists/*

RUN set -ex \
    && a2enmod proxy_fcgi setenvif headers rewrite security2 \
    && sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && a2dissite 000-default \
    && rm /etc/apache2/conf-enabled/other-vhosts-access-log.conf \
    && echo "ServerName localhost" > /etc/apache2/conf-enabled/ServerName.conf \
    && sed -i 's/^ServerTokens.*/ServerTokens Prod/' /etc/apache2/conf-enabled/security.conf \
    && sed -i 's/^ServerSignature.*/ServerSignature Off/' /etc/apache2/conf-enabled/security.conf \
    && echo 'SecServerSignature " "' > /etc/apache2/conf-enabled/custom.conf \
    && mkdir -p /var/run/apache2 /var/lock/apache2 \
    && chgrp -R 0 /var/log/apache2 /var/run/apache2 /var/lock/apache2 \
    && chmod -R g=u /var/log/apache2 /var/run/apache2 /var/lock/apache2 \
    && ln -sf /proc/self/fd/1 /var/log/apache2/access.log \
    && ln -sf /proc/self/fd/1 /var/log/apache2/error.log \
    && echo ok > /var/www/html/index.html

ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid
ENV APACHE_SERVER_NAME localhost

COPY php-fpm.conf /etc/apache2/conf-enabled/php-fpm.conf

USER www-data:0
STOPSIGNAL SIGWINCH
ENV STOPSIGNAL WINCH
EXPOSE 8080
ENTRYPOINT ["apache2", "-DFOREGROUND"]