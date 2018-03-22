<?php
require './vendor/autoload.php';

use Avir\Database\Modules\DBpdo;
use Avir\Database\Modules\Config;
use Avir\Database\Modules\DBquery;


$oi = new DBquery();
print_r($oi->dbCall('insert_into_users'));
//print_r(Config::getQueries());
//print_r($r);