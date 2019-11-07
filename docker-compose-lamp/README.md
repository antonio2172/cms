# LAMP stack built with Docker Compose

![Landing Page](https://preview.ibb.co/gOTa0y/LAMP_STACK.png)

This is a basic LAMP stack environment built using Docker Compose. It consists following:

* PHP
* Apache
* MySQL
* phpMyAdmin

## Installation
- first copy .env `cp sample.env .env`
- And then run the `docker-compose up -d`.

## Docker copy alias 😝
```
alias cms-copy=_cms-copy_func
_cms-copy_func() {
    if [ -d "$PWD/cms" ]; then
        echo "copying"
        docker cp $PWD/cms cms-webserver:/var/www/html/
        echo "setting permissions"
        docker exec cms-webserver bash -c "chmod 777 /var/www/html/cms/backend/views/images/articulos/temp"
        docker exec cms-webserver bash -c "chmod 777 /var/www/html/cms/backend/views/images/slide"
        echo "that's all folks"
    else
        echo "not here buddy!"
    fi
}
```

Thanks [https://github.com/sprintcube/docker-compose-lamp.git](https://github.com/sprintcube/docker-compose-lamp.git) ✌
