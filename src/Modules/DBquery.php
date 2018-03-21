<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 20.03.2018
 * Time: 16:05
 */

namespace Avir\Database\Modules;

use PDO;
use PDOStatement;


class DBquery extends Query implements QueryPrepare
{

    public function __construct()
    {
        $pdoObj = new DBpdo();
        static::$pdo = $pdoObj->getPDO();
    }

    public function readQuery($queryName): string
    {
        $root = Config::getRoot();
        $file  = "$root/ConfDB/queries.php"; require $file; // Connecting the queries file
        $conf = Config::getConfig();
        return str_replace('DataBaseName',$conf['database'],constant($queryName));
    }

    public function getStmt(string $query, $values = []): PDOStatement
    {
        if (!empty($values)) {
            $stmt = self::$pdo->prepare($query);
            $stmt->execute($values);
        }
        else {
            $stmt = self::$pdo->query($query);
        }
        return $stmt;
    }

    public function prepareQuery(array $args)
    {
        if (!empty($args['values'])) {
            $argv = ['options' => $this->fetchOptionSet($args['fetchOptionNum']), 'values' => true];
            return $this->setCustomFetchRules($args['customFetchRule'], $argv);
        }
        else {
            $argv = ['query' => $args['queryName'], 'values' => false];
            return $this->setCustomFetchRules($args['customFetchRule'], $argv);
        }
    }
    public function setCustomFetchRules($nameRule, $argv){
        $rules = new FetchRules();
        try {
            return $rules->selectFetchRule($nameRule, $argv);
        }
        catch (\Exception $e){
            echo 'Invalid request to the database: '.$e->getMessage();
        }
    }
    public function sendQuery(array $args)
    {
            return $this->prepareQuery($args);
    }

    public function dbCall(string $queryName, $args = array('values' => array(),
        'fetchOptionNum' => 0, 'customFetchRule' => 'fetch'))
    {
        if (!array_key_exists('customFetchRule', $args)){
            $args['values'] = $args[0];
            $args['fetchOptionNum'] = $args[1];
            $args['customFetchRule'] = $args[2];
        }
        $args['queryName'] = $this->readQuery($queryName);
        return $this->sendQuery($args);
    }

    private function fetchOptionSet($fetchOption)
    {
        switch ($fetchOption)
        {
            case 0:
                $this->fetchOption = PDO::ATTR_DEFAULT_FETCH_MODE; break;
            case 1:
                $this->fetchOption = PDO::FETCH_ASSOC; break;
            case 2:
                $this->fetchOption = PDO::FETCH_BOTH; break;
            case 3:
                $this->fetchOption = PDO::FETCH_LAZY; break;
            case 4:
                $this->fetchOption = PDO::FETCH_OBJ; break;
            default :
                throw new \InvalidArgumentException("$fetchOption is not valid number the the fetch option. Use [0-4]");
        }
    }
}