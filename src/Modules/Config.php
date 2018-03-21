<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 21:24
 */
namespace Avir\Database\Modules;

use Symfony\Component\Yaml\Yaml;

class Config
{
    /**
     * @var array
     */
    protected static $config;

    /**
     * @var array
     */
    protected static $queries;

    /**
     * Root of the project
     * @var string
     */
    public static $root;

    /**
     * #Get a configuration from /.config
     * @return array
     */
    public static function getConfig()
    {
        if(empty(self::$config)) {
            $root = self::getRoot();
            self::$config =  Yaml::parseFile("$root/ConfDB/.config");
        }
        return self::$config;
    }

    /**
     * Getting queries from /ConfDB/.queries
     * @return array
     */
    public static function getQueries()
    {
        //TODO ss
        if(empty(self::$queries)) {
            $root = self::getRoot(); $file  = "$root/ConfDB/queries.php";
            require $file;
            self::$queries = strtoupper();
        }
        return self::$queries;
    }

    /**
     * Getting root the project
     * @return string
     */
    public static function getRoot()
    {
        preg_match("%.*dbconnect%",dirname(__DIR__),$m);
        return self::$root = preg_filter('%.{1}dbconnect%','',$m[0]);
    }
}