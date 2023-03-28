# Use the official Nginx image as the base image
FROM nginx:alpine

RUN apk add --update openssl

RUN rm /etc/nginx/conf.d/default.conf

COPY docker/nginx/config/local /etc/nginx/conf.d
COPY docker/nginx/config/nginx.conf /etc/nginx/nginx.conf
