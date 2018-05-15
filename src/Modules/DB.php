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
        $file  = "$root/config/queries.php"; require $file; // Connecting the queries file
        $conf = $this->getConfig();
        @$queryConst = constant($queryName);
        if ($queryConst == null){
            echo "Not found constant $queryName in /config/queries.php as \$queryName";
            exit();
        }
        return str_replace('DataBaseName',$conf['database'],$queryConst);
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
        if (empty(static::$pdo)){
            $this->getConnect();
        }
        if (!empty($values)) {
            $stmt = self::$pdo->prepare($query);
            $stmt->execute($values);
        }
        else {
            try {
                $stmt = self::$pdo->query($query);
            }
            catch (\Exception $e){
                $stmt = null;
                echo 'Database query error: '.$e->getMessage();
            }
        }
        if ($stmt === null){
            try {
                throw new \Exception('. Cannot stmt get.');
            }
            catch (\Exception $e){
                echo $e->getMessage();
                exit();
            }
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
            return $rules->fetchRule($stmt, $fetchRule ,$fetchOption);
        }
        catch (\Exception $e){
            echo 'Invalid request to the database: '.$e->getMessage();
        }
    }

    /**
     * @param string $queryName
     * @param array $values
     * @param int $fetchOption
     * @param string $fetchRule
     * @return array|mixed
     */
    public function dbCall(string $queryName, $values = array(),
        $fetchOption = 0, $fetchRule = 'fetch')
    {
        if (empty(static::$pdo)){
            $this->getConnect();
        }
        $args['values'] = $values;
        $args['fetchRule'] = $fetchRule;
        $args['query'] = $this->readQuery($queryName);
        $args['fetchOption'] = $fetchOption;
        return $this->prepareQuery($args);
    }

    public function Dtest($pdo, $query)
    {
        static::$pdo = $pdo;
        $stmt = self::$pdo->query($query);
        return $stmt->fetch();
    }

}
