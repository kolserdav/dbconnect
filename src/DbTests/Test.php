<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 23:54
 */

namespace Avir\Database\DbTests;

use Avir\Database\Modules\Config;
use PHPUnit\Framework\TestCase;
use Avir\Database\Modules\Dbpdo;
use PDO;

class Test extends TestCase
{
    /**
     * Root the project
     * @var string
     */
    protected $root;

    protected function setUp ()
    {
        /**
         * Getting root the project
         */
        preg_match("%.*dbconnect%",dirname(__DIR__),$m);
        $this->root = preg_filter('%.{1}dbconnect%','',$m[0]);
    }
    public function testDbConnect()
    {
        $this->assertFileExists("$this->root/ConfDB/.config");
        $this->assertFileExists("$this->root/ConfDB/queries.php");
        $this->assertIsReadable("$this->root/ConfDB/.config");
        $this->assertIsReadable("$this->root/ConfDB/queries.php");
        $this->assertNotNull(Config::getRoot());
        $this->assertInternalType('array', Config::getConfig());
        $this->assertInternalType('string', Config::getQueries());
        $this->assertInternalType('object', new Dbpdo());
    }


}