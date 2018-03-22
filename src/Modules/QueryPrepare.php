<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 20.03.2018
 * Time: 23:23
 */

namespace Avir\Database\Modules;

use PDOStatement;

interface QueryPrepare
{
    /**
     * Getting PDOStatement instance with a custom params
     * @param $query string
     * @param $values
     * @return PDOStatement
     */
    public function getStmt(string $query, $values = []): PDOStatement;

    /**
     * Prepare query with params
     * @param array $args ['values' = array(), 'query' = string, ]
     */
    public function prepareQuery(array $args);

    /**
     * Read query, prepare, send and return value in the form of an object
     * @param string $queryName
     * @param array $values = array()
     * @param $fetchOptionNum = 0
     * @param $customFetchRule = 'fetch'
     */
    public function dbCall(string $queryName,  $values = array(), $fetchOptionNum = 0, $customFetchRule = 'fetch');
}