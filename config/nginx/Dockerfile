FROM nginx:alpine

COPY task.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

COPY ./frontend/build/ .
