#!/bin/bash

#Add references to new test files to this file.
#Run it by opening a Bash console, typing "cd /..", navigating to this folder (maybe cd var/www) and typing ./runalltests.sh
#The first time you try to run it it will probably fail because you don't have permission, to get around this type "chmod +x runalltests.sh"

phpunit --configuration tests/phpunit.xml tests/DatabaseConstraintTest
phpunit --configuration tests/phpunit.xml tests/ProductDBTest
phpunit --configuration tests/phpunit.xml tests/ProductTest
phpunit --configuration tests/phpunit.xml tests/SaleDBTest
phpunit --configuration tests/phpunit.xml tests/SaleLineDBTest
phpunit --configuration tests/phpunit.xml tests/SaleLineTest