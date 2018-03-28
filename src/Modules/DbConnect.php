<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 20:09
 */

namespace Avir\Database\Modules;

use PDO;
use Symfony\Component\Yaml\Yaml;

abstract class DbConnect
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $driver;
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
    public $dsn;
    /**
     * @var array
     */
    protected $opt;
    /**
     * @var \PDO::object
     */
    protected static $pdo;
    /**
     * @var array
     */
    protected $config;

    /**
     * Root of the project
     * @var string
     */
    public $root;

    /**
     * #Get a configuration from /.config
     * @return array
     */
    /**
     * DbConnect constructor.
     */

    public function getConnect()
    {
        $data = $this->getConfig();
        $this->host = $data['host'];
        $this->driver = $data['driver'];
        $this->user = $data['user'];
        $this->password = $data['password'];
        $this->charset = $data['charset'];
        $this->database = $data['database'];
        $this->port = $data['port'];
        $this->dsn = "$this->driver:host={$this->host};\
        port={$this->port};dbname={$this->database};charset={$this->charset}";
        $this->opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        static::$pdo = $this->getPDO();
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        try {
            return new PDO($this->dsn, $this->user, $this->password, $this->opt);
        }
        catch (\Exception $e){
            echo 'Invalid database connect: '.$e->getMessage();
            exit();
        }
    }
    public function getConfig()
    {
        if(empty($this->config)) {
            $root = self::getRoot();
            try {
                $this->config = Yaml::parseFile("$root/config/database.yaml");
            }
            catch (\Exception $e){
                echo "Error write file database.yaml. ".$e->getMessage();
                $this->config = false;
            }
            if (!$this->config){
                try {
                    throw new \Exception('. /config/database.yaml not found');
                }
                catch (\Exception $e){
                    echo $e->getMessage();
                    exit();
                }
            }
        }

        return $this->config;
    }

    /**
     * Getting root the project
     * @return string
     */
    public function getRoot()
    {
        preg_match("%.*vendor%",dirname(__DIR__),$m);
        return $this->root = preg_filter('%.{1}vendor%','',$m[0]);
    }

}