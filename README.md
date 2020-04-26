# GitHub archive keyword API

## How to start the project

### Copy the .env file

```bash
cp .env.dist .env
```

**Change the contents**

### Start the docker env

```bash
docker-compose -p gha-keyword up --build
```

### Fill the APP key

**wait to see that the first composer install is done**

```bash
docker exec php-7.4-nginx php artisan key:generate
```

### Migrate the database

```bash
docker exec php-7.4-nginx php artisan migrate
```

### Run the tests

```bash
docker exec php-7.4-nginx composer run test
```
