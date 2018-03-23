<?php
require './vendor/autoload.php';



use Avir\Database\Modules\DB;
$rule = new \Avir\Database\Modules\FetchRules();
$oi = new DB();
$stmt = $oi->getStmt('SELECT * FROM `users`');
//$o = $rule->dbCall(insert_values, [1,2,3],1);
echo dirname((__FILE__).'/ConfDB/.config');

//print_r($o);

//print_r(Config::getQueries());
//print_r($r);