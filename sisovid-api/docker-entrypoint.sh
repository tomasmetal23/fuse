#!/bin/bash

/wait

#php artisan migrate:fresh

php -S 0.0.0.0:8020 -t public
