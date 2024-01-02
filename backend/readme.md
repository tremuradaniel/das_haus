# Start up

`docker-compose up -d server` - create the necessary containers

`docker-compose run --rm php symfony symfony/skeleton:"6.3.*" .` - create
the symfony project. run only once

`docker-compose run --rm -it php composer require symfony/maker-bundle --dev` - install maker

`docker-compose run --rm php bin/console  doctrine:migrations:migrate`
