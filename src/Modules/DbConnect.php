<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 20:09
 */

namespace Avir\Database\Modules;

use PDO;

abstract class DbConnect
{
    /**
     * @var string
     */
    protected $host;
    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $charset;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $dsn;
    /**
     * @var array
     */
    protected $opt;
    /**
     * DbConnect constructor.
     */
    public function __construct()
    {
        $data = Config::getConfig();
        $this->host = $data['host'];
        $this->user = $data['user'];
        $this->password = $data['password'];
        $this->charset = $data['charset'];
        $this->database = $data['database'];
        $this->port = $data['port'];
        $this->dsn = "mysql:host={$this->host};\
        port={$this->port};dbname={$this->database};charset={$this->charset}";
        $this->opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

    }

    /**
     * @return PDO
     */
    abstract public function getPDO();

}