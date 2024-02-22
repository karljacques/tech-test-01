# Introduction
I've probably gone overboard for this tech test. I was supposed to spend two hours but I've probably doubled that, whoops. 
I had fun with it.

The test was to be completed without any framework, which I found quite broad, so I've opted to pull in some 
very basic components for Routing, DI and rendering to help. 
I wanted to show how I'd approach a real project, and this largely architecture is framework-agnostic in my opinion. 

# How to run

You will of course require docker for this. Navigate to the root directory and execute the following commands to bring it up.
```
docker compose up -d
docker compose exec php composer i
```

Then, run the ad-hoc migrations system with:
```
docker compose exec php php src/migrate.php
```

You should now be able to access the page using the address `localhost`, unless you have something blocking port 80, in which case you'll need to pick a different port for nginx in `docker-compose.yml`

# Running tests

Run static analysis with:
```
docker compose exec php ./vendor/bin/psalm
```

Run the unit tests with:
```
 docker compose exec php vendor/bin/phpunit tests/Unit
```

Run the integration tests with:
```
 docker compose exec php vendor/bin/phpunit tests/Integration
```

The integration tests won't work unless you've migrated the test database first.
