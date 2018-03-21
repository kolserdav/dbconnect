<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 20.03.2018
 * Time: 23:54
 */

namespace Avir\Database\Modules;

use Avir\Database\Modules\DBpdo;

abstract class Query
{
    /**
     * @var \PDO::object
     */
    protected static $pdo;

    /**
     * Result of read /ConfigDB/.queries.php
     * @var string
     * @method readQuery()
     */
    protected $queries;

    /**
     * Query for prepare
     * @var string
     */
    protected $preparedQuery;

    /**
     * Prepared query
     * @var string
     */
    protected $query;

    /**
     * Result of send query
     * @var mixed
     */
    protected $result;

    /**
     * Custom variables for query
     * @var array
     */
    protected $values;

    /**
     * Custom value of the query name
     * @var string
     */
    protected $queryName;

    /**
     * Setting PDO::fetch option
     * @var \PDO::const
     */
    protected $fetchOption;

    /**
     * @var object
     */
    protected $stmt;

    /**
     * Custom callback fetch rule
     * @var string
     */
    protected $callDBcallback;
    /**
     * @var mixed
     */
    protected $fetch;

}