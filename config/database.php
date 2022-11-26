<?php

define ('DB_HOST','localhost');
define ('DB_PORT','5432');

define ('DB_USER','postgres');
define ('DB_PASSWORD','admin');

define ('DB_NAME','devweb');

define ('POSTGRES_DNS',"pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";user=".DB_USER.";password=".DB_PASSWORD);