<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 23:54
 */

namespace Avir\Database\Tests;

use PHPUnit\Framework\TestCase;
use Avir\Database\Modules\Dbpdo;
use PDO;

class Test extends TestCase
{

    protected function setUp ()
    {
        preg_match('%.*modules%',dirname(__DIR__),$m);
        $_SERVER['DOCUMENT_ROOT'] = str_replace('modules','',$m[0]);
    }
    public function testDbConnect()
    {
        $this->assertFileExists("$_SERVER[DOCUMENT_ROOT]/.config");
        $this->assertIsReadable("$_SERVER[DOCUMENT_ROOT]/.config");
        $this->assertInternalType('object', new Dbpdo());
    }


}