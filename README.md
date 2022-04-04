# How run app

    docker-compose up -d
    docker-compose exec php bin/console doctrine:migrations:migrate

# How run test

    docker-compose exec php bin/console doctrine:database:create --env=test
    docker-compose exec php bin/console doctrine:migrations:migrate --env=test
    docker-compose exec php bin/phpunit
