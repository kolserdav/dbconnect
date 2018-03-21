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
     * @param array $args
     */
    public function prepareQuery(array $args);

    /**
     * Send query and save result
     * @param array $args
     */
    public function sendQuery(array $args);

    /**
     * Read query, prepare, send and return value in the form of an object
     * @param string $queryName
     * @param array $args = array()
     */
    public function dbCall(string $queryName, $args = array('values' => array(), 'fetchOptionNum' => 0, 'customFetchRule' => 'fetch'));
}