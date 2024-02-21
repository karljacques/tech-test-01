# How to run

```
docker compose up -d
docker compose exec php composer i
```

# Running tests

Run static analysis with:
```
docker compose exec php ./vendor/bin/psalm
```

Run the unit tests with:
```
 docker compose exec php vendor/bin/phpunit tests/Unit
```
