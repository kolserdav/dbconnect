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
     * Root of the site
     * @var string
     */
    public static $root;
    /**
     * #Get a configuration from /.config
     * @return array
     */
    public static function get()
    {
        if(empty(self::$config)) {
            $root = self::getRoot();
            self::$config =  Yaml::parseFile("$root/.config");
        }
        return self::$config;
    }
    public static function getRoot()
    {
        return self::$root = $_SERVER['DOCUMENT_ROOT'];
    }
}