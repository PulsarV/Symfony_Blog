#!/bin/bash
# This script will perform all the necessary settings to launch the blog

clear
echo "Select action:"
echo "1 - Install blog (full configuration and load fixtures)"
echo "2 - Recreate database and load fixtures"
echo "3 - Recreate database"
echo "4 - Load fixtures"
echo "5 - Quit"

read Keypress

case "$Keypress" in
1)
    echo
    echo SETUP BACKEND ...
    echo =================
    composer install
    echo
    echo SETUP FRONTEND ...
    echo ==================
    npm install -S bower gulp less gulp-less gulp-clean gulp-concat gulp-uglify
    ./node_modules/.bin/bower install -S bootstrap
    ./node_modules/.bin/gulp
    echo
    echo CREATE DATABASE ...
    echo ==================
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOAD FIXTURES ...
    echo =================
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
2)
    echo
    echo RECREATE DATABASE ...
    echo ==================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOAD FIXTURES ...
    echo =================
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
3)
    echo
    echo RECREATE DATABASE ...
    echo ==================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
;;
4)
    echo
    echo LOAD FIXTURES ...
    echo =================
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
5)
    exit 0
;;
*)
    echo "ERROR! UNDEFINED ACTION"
    exit 0
;;
esac
echo
echo =======================
echo ALL OPERATION COMPLETED
exit 0