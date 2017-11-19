`docker-compose up -d`

`docker exec -it rasenko_backend_web /bin/bash`

`cd /var/www/html`

`composer update`

`php init` выбрать dev окружение

`php yii migrate`

`php yii fixture "*"`

доступно на localhost:8080

Учетка админа TestUser0 123456

Остальные пользователи TestUser[1-49] пароль на всех 123456