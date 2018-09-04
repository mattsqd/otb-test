#!/bin/sh

# If else statement to set default parameters if no parameters was passed.
if [ -z "$*" ]; then
  BEHAT_PARAMETERS="--format=pretty"
else
  BEHAT_PARAMETERS="$*"
fi

# Start Php and Selenium server containers
docker-compose -f docker-compose.yml up -d

# Additional time for Selenium.
sleep 2

# Run tests inside the Php container.
docker-compose -f docker-compose.yml run --rm php composer self-update
docker-compose -f docker-compose.yml run --rm php composer install -n --prefer-dist
docker-compose -f docker-compose.yml run --rm php bin/behat --init

# Run tests inside the Php container.
docker-compose -f docker-compose.yml run --rm php bin/behat "$BEHAT_PARAMETERS"

# Stop and remove containers.
docker-compose -f docker-compose.yml down
