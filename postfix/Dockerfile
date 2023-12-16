FROM ubuntu:22.04
ARG DEBIAN_FRONTEND=noninteractive
ARG TZ=America/Sao_Paulo
USER root
RUN set -ex \
    && sed -i "s/archive.ubuntu.com/br.archive.ubuntu.com/g" /etc/apt/sources.list \
    && echo '#!/bin/sh\nexit 0' > /usr/sbin/policy-rc.d \
    && echo "postfix postfix/mailname string example.com" | debconf-set-selections \
    && echo "postfix postfix/main_mailer_type string 'Internet Site'" | debconf-set-selections \
    && apt-get update \
    && apt-get -y install --no-install-recommends \
      tzdata postfix libsasl2-modules mailutils iproute2 telnet \
    && rm -rf /var/lib/apt/lists/*

COPY --chmod=600 main.cf /etc/postfix/main.cf
COPY --chmod=600 header_checks /etc/postfix/header_checks
COPY --chmod=600 generic /etc/postfix/generic

RUN postmap /etc/postfix/generic

CMD ["/usr/sbin/postfix", "start-fg"]

STOPSIGNAL SIGTERM
EXPOSE 25
