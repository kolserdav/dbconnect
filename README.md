  git push --set-upstream origin dev

 This is a simple module that returns an object of the PDO class. MySql.  

_Dependecies_  
`require  
php : ^7.0,    
symfony/yaml : ^4.0`  
`reguire-dev:  
phpunit/phpunit : ^7.0`  
`"phpunit/dbunit": "^4.0"`  
  

_Instalation_  
-$ `composer require kolserdav/dbconnect`   
-$ `composer update`   
-rename file .config-example to .config  
-copy folder ConfDB in root of your project  
-add in file .config self variables  

_Using_  

`use Avir\Database\Modules\DB;`    

 `$db = new DB;`  
 
In order to get PDO:   
  
 `$pdo = $db->getPDO();`  
   
To get STMT:

`$db->getStmt($query,[$values] = array());`  

To send a request:  

`$db->stmtCall($stmt, $fetchRule, $fetchOption);`  

Or insert your queries in to /Conf.db/queries.php
and use:

`$db->callDB($queryName, [$values] = array(), $fetchOption = 0, $fetchRule = 'fetch')`  

To fine-tune the selection rules: 
need call to FetchRule::class methods

`hisFetch()`,`hisFetchColumn()`...

While I do not know, whether to develop it or not.