# otb-test

This repo is to test the error described in this ticket WYNDHAM8105-375 where users could not log into the site because of a cache issue.

To run locally with docker-compose:

``sh tests.sh``

Failed step will have screenshots saved in ``behat_screenshots`` folder if the step is a @javascript scenario.