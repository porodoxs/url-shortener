FROM nginx:1.13.7-alpine

ENV TERM xterm

RUN apk upgrade --update && apk add bash \
    && rm -rf /apk /tmp/* /var/cache/apk/*

COPY build/nginx/nginx.conf /etc/nginx/nginx.conf

COPY public /var/www/url-shortener/public

EXPOSE 80 443
CMD ["nginx", "-g", "daemon off;"]
