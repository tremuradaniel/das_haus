FROM nginx:1.25
 
WORKDIR /etc/nginx/conf.d
 
COPY nginx/nginx.conf .
 
RUN mv nginx.conf default.conf

WORKDIR /var/www/html
 
COPY backend_api .
