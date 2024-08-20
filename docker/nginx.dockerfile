FROM nginx:stable-alpine-perl

# specify working directory
WORKDIR /app

# copy files from host to container
COPY . .






