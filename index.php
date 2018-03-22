<?php
require './vendor/autoload.php';

use Avir\Database\Modules\DBpdo;
use Avir\Database\Modules\Config;
use Avir\Database\Modules\DB;


$oi = new DB();
print_r($oi->dbCall('insert_values', ['da222sd','a21ss','g2sg'], 1));
//print_r(Config::getQueries());
//print_r($r);