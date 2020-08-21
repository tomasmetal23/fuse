#!/bin/bash

/wait

composer install

php -S localhost:8010 -t public