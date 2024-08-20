FROM php:8.3-fpm-alpine

# specify workding directory
WORKDIR /app

# Install PHP extensions and dependencies
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apk update && apk add --no-cache supervisor

# copy files from host to container
COPY . .

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Create necessary directories for Supervisor logs
RUN mkdir -p /var/log/supervisor

# Create a non-root user and group
RUN addgroup -g 1000 -S appgroup && adduser -u 1000 -S appuser -G appgroup

RUN chown -R appuser:appgroup /app /var/log/supervisor

# switch to non root user
USER appuser

# install application depencies
RUN composer install

# copy supervisor configuration
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# expose port 9000
EXPOSE 9000

CMD ["/usr/bin/supervisord", "-n"]


