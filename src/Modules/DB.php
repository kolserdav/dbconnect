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


class DB extends DbConnect implements QueryPrepare
{

    /**
     * @var object
     */
    protected $stmt;



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
        return $this->setCustomFetchRules($args['customFetchRule'], $args);

    }

    public function setCustomFetchRules($nameRule, $argv)
    {
        $rules = new FetchRules();
        try {
            return $rules->selectFetchRule($nameRule, $argv);
        }
        catch (\Exception $e){
            echo 'Invalid request to the database: '.$e->getMessage();
        }
    }


    public function dbCall(string $queryName, $values = array(),
        $fetchOptionNum = 0, $customFetchRule = 'fetch')
    {
        $args['values'] = $values;
        $args['customFetchRule'] = $customFetchRule;
        $args['query'] = $this->readQuery($queryName);
        $args['fetchOption'] = $this->fetchOptionSet($fetchOptionNum);
        return $this->prepareQuery($args);
    }

    private function fetchOptionSet($fetchOption)
    {
        switch ($fetchOption)
        {
            case 0:
                return PDO::ATTR_DEFAULT_FETCH_MODE;
            case 1:
                return PDO::FETCH_ASSOC;
            case 2:
                return PDO::FETCH_BOTH;
            case 3:
                return PDO::FETCH_LAZY;
            case 4:
                return PDO::FETCH_OBJ;
            default :
                throw new \InvalidArgumentException("$fetchOption is not valid number the the fetch option. Use [0-4]");
        }
    }
}