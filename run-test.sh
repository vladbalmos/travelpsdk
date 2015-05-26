#!/bin/bash

source ./env
vendor/bin/phpunit -c tests/phpunit.xml.dist $@
