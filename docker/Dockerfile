ARG IMAGE
FROM $IMAGE

ENV DOCKERIZE_VERSION v0.6.1

#Install Mongodb
#RUN apk update && \
#    pecl install mongodb && \
#    docker-php-ext-enable mongodb

# Install MySql
RUN docker-php-ext-install pdo_mysql pcntl

#Install package to rabbitmq
RUN docker-php-ext-install sockets \
    && rm  -rf /tmp/* /var/cache/apk/*
    
# Install Dockerize
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz