FROM nginx:1.25.1-alpine3.17

ARG NGINX_UID=101 NGINX_GID=101

RUN apk add --no-cache shadow &&\
    usermod -u ${NGINX_UID} nginx &&\
    groupmod -g ${NGINX_GID} nginx &&\
    apk del shadow

COPY ./conf.d/* /etc/nginx/conf.d/

COPY ./docker-entrypoint.d/* /docker-entrypoint.d/
