## Run tests
- `cd docker`
- `cp .env.dist .env`
- задать значения в `docker/.env`
- `docker-compose build`
- `docker-compose up -d`
- `docker-compose exec --user=app app bash`
- `composer install`
- `composer test`
