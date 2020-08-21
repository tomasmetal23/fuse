#!/bin/bash

/wait

php artisan migrate

php -S 0.0.0.0:8010 -t public