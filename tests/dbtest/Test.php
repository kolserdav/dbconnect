<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 23:54
 */

namespace Avir\Database\Dbtest;

use Avir\Database\Modules\FetchRules;
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

    /**
     * @var FetchRules
     */
    protected $rules;

    protected function setUp ()
    {
        preg_match("%.*vendor%",dirname(__DIR__),$m);
        $this->root = preg_filter('%.{1}vendor%','',$m[0]);
        $this->db = new DB();
        $this->stmt = $this->db->getStmt("SELECT `id` FROM `users` WHERE `name` = ?", ['Mark']);
        $this->rules = new FetchRules();
    }
    public function testDbConnect()
    {

        $this->assertFileExists("$this->root/config/database.yaml");
        $this->assertFileExists("$this->root/config/queries.php");
        $this->assertIsReadable("$this->root/config/database.yaml");
        $this->assertIsReadable("$this->root/config/queries.php");
        $this->assertInternalType('array', $this->db->getConfig());
        $this->assertInstanceOf(\PDO::class, $this->db->getPDO());
    }

    public function testDbQuery()
    {
        $this->assertEquals(['id'=>1],$this->db->stmtCall($this->stmt, 'fetch',PDO::FETCH_ASSOC));
        $this->assertEquals("SELECT `id` FROM `users` WHERE `name` = ?",$this->db->readQuery(test_query));
        $this->assertInstanceOf(\PDOStatement::class, $this->db->getStmt("SELECT * FROM `users`" ));
        $this->assertInstanceOf(\PDOStatement::class, $this->db->getStmt("SELECT `id` FROM `users` WHERE `name` = :name", ['name'=>'Mark']));
        $this->assertNotNull($this->rules->fetchRule($this->stmt, 'fetch',PDO::FETCH_ASSOC));
        $this->assertNotNull($this->rules->hisGetColumnMeta($this->stmt, 3));
        //$this->assertNotNull($this->db->dbCall(insert_values, ['test', 'test', 'test'], 1));
        //TODO testing the database is difficult ... probably

    }


}