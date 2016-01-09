#!/bin/bash
# This script will perform all the necessary settings to launch the blog

echo 
echo SETUP BACKEND ...
echo =================

sudo composer self-update
composer install
rm -rf app/cache/*
rm -rf app/logs/*
setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs

echo 
echo SETUP FRONTEND ...
echo ==================

sudo apt-get install nodejs
npm install -S bower gulp less gulp-less gulp-clean gulp-concat gulp-uglify
./node_modules/.bin/bower install -S bootstrap
#./node_modules/.bin/gulp

echo 
echo SETUP DATABASE ...
echo ==================

#./app/console doctrine:database:create
#./app/console doctrine:schema:update --force

echo 
echo LOAD FIXTURES ...
echo =================

#./app/console hautelook_alice:doctrine:fixtures:load --no-interaction

echo 
echo =======================
echo ALL OPERATION COMPLETED
