<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 19.03.2018
 * Time: 21:24
 */

namespace Avir\Database\Modules;

use PDO;

class DBpdo extends DbConnect
{
    /**
     * @return PDO
     */
    public function getPDO()
    {
        return new PDO($this->dsn, $this->user,$this->password, $this->opt);
    }
}