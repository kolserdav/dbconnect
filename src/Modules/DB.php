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
     * PDOStatement instance
     * @var object
     */
    protected $stmt;

    /**
     * Read queries from file
     * @param $queryName
     * @return string
     */
    public function readQuery($queryName): string
    {
        $root = $this->getRoot();
        $file  = "$root/ConfDB/queries.php"; require $file; // Connecting the queries file
        $conf = $this->getConfig();
        return str_replace('DataBaseName',$conf['database'],constant($queryName));
    }

    /**
     * @param array $args
     * @return array|mixed
     */
    public function prepareQuery(array $args)
    {
        $this->stmt = $this->getStmt($args['query'], $args['values']);
        return $this->stmtCall($this->stmt, $args['fetchRule'], $args['fetchOption']);

    }

    /**
     * Getting PDOStatement instance
     * @param string $query (sql syntax)
     * @param array $values
     * @return PDOStatement
     */
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

    /**
     * @param \PDOStatement object
     * @param string $fetchRule
     * @param $fetchOption
     * @return array|mixed
     */
    public function stmtCall(PDOStatement $stmt, $fetchRule, $fetchOption)
    {
        $rules = new FetchRules();
        try {
            return $rules->selectFetchRule($stmt, $fetchRule ,$fetchOption);
        }
        catch (\Exception $e){
            echo 'Invalid request to the database: '.$e->getMessage();
        }
    }

    /**
     * @param string $queryName
     * @param array $values
     * @param int $fetchOptionNum
     * @param string $customFetchRule
     * @return array|mixed
     */
    public function dbCall(string $queryName, $values = array(),
        $fetchOptionNum = 0, $customFetchRule = 'fetch')
    {
        $args['values'] = $values;
        $args['fetchRule'] = $customFetchRule;
        $args['query'] = $this->readQuery($queryName);
        $args['fetchOption'] = $this->fetchOptionSet($fetchOptionNum);
        return $this->prepareQuery($args);
    }

    /**
     * @param $fetchOption
     * @return int
     */
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