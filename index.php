<?php
require 'vendor/autoload.php';
use Avir\Database\Modules\Dbpdo;
use Avir\Database\Modules\Config;
$t = new Dbpdo();
$t->getPDO();
//$f = Config::get();
var_dump($t);
//echo "$t->host";
//$dir = dirname(__DIR__);
preg_match('%.*modules%',$dir,$m);
//echo strlen($m[0]);
//echo str_replace('modules','',$m[0]);
//echo "<br>$m[0]";
//var_dump($m);