### Projecto Dicromo

#### Requisitos

- Docker

#### Instalacion

Todos los comandos que se veran a continuación deberán ser ejecutados en el root del proyecto descargado en tu maquina local

1) Ejecute el siguiente comando en la raiz de su proyecto

    ```bash
        cp .env.example .env
    ```

2) Iniciar Docker

    ```bash
        docker-compose up -d
    ```

3) Una vez terminado el proceso de instalacion Docker ejecutamos...

    ```bash
        docker exec dicromo_test-laravel.test-1 composer install
    ```
- En caso de que no funcione, revisa bien el nombre del contenedor de Laravel...
- Ya finalizada la instalacion de Composer, puedes empezar a ejecutar comandos sail!!

4) Ahora con sail correremos las migraciones de mongodb
    
    ```bash
        ./vendor/bin/sail artisan migrate
    ```
5) Como adicional tambien puedes ejecutar los tests

    ```bash
        ./vendor/bin/sail artisan test
    ```

### Ya puedes utilizar la app, mientras tanto dejaré una lista de los endpoints

#### Autenticación (`api/auth/`)

- POST `{base_uri}/api/auth/login`
- POST `{base_uri}/api/auth/register`
- POST `{base_uri}/api/auth/logout`
- POST `{base_uri}/api/auth/user`
- PUT `{base_uri}/api/auth/user`
- DELETE `{base_uri}/api/auth/user`


#### Gestión de Tareas (`api/tasks`)

- GET `{base_uri}/api/tasks/`
- POST `{base_uri}/api/tasks/`
- PUT `{base_uri}/api/tasks/{id}?user_id`
- DELETE `{base_uri}/api/tasks/{id}?user_id`
