<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 23:54
 */

namespace Avir\Database\DbTests;

use PHPUnit\Framework\TestCase;
use Avir\Database\Modules\DB;
use PDO;

class Test extends TestCase
{
    /**
     * Root the project
     * @var string
     */
    protected $root;
    /**
     * @var \PDOStatement
     */
    protected $stmt;

    /**
     * @var DB
     */
    protected $db;

    protected function setUp ()
    {
        preg_match("%.*dbconnect%",dirname(__DIR__),$m);
        $this->root = preg_filter('%.{1}dbconnect%','',$m[0]);
        $this->db = new DB();
        $this->stmt = $this->db->getStmt("SELECT `id` FROM `users` WHERE `name` = :name", ['name'=>'Mark']);
    }
    public function testDbConnect()
    {

        $this->assertFileExists("$this->root/ConfDB/.config");
        $this->assertFileExists("$this->root/ConfDB/queries.php");
        $this->assertIsReadable("$this->root/ConfDB/.config");
        $this->assertIsReadable("$this->root/ConfDB/queries.php");
        $this->assertInternalType('array', $this->db->getConfig());
        $this->assertInstanceOf(\PDO::class, $this->db->getPDO());
    }

    public function testDbQuery()
    {
        $this->assertEquals(['id'=>1],$this->db->stmtCall($this->stmt, 'fetch',PDO::FETCH_ASSOC));
        $this->assertEquals("SELECT `id` FROM `users` WHERE `name` = ?",$this->db->readQuery(test_query));
        $this->assertInstanceOf(\PDOStatement::class, $this->db->getStmt("SELECT * FROM `users`" ));
        $this->assertInstanceOf(\PDOStatement::class, $this->db->getStmt("SELECT `id` FROM `users` WHERE `name` = :name", ['name'=>'Mark']));
        $this->assertInstanceOf(\PDORow::class,$this->db->stmtCall($this->stmt, 'fetch',PDO::FETCH_LAZY));

    }


}