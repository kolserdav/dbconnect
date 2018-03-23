<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 21.03.2018
 * Time: 14:48
 */

namespace Avir\Database\Modules;

use PDO;
use PDOStatement;


class FetchRules extends DB
{
    public function fetchRule($stmt, $fetchRule, $fetchOption)
    {
        switch ($fetchRule){
            case 'fetch':
                return $this->hisFetch($stmt, $fetchOption);
            case 'fetchAll':
                return $this->hisFetchAll($stmt, $fetchOption);
            case 'fetchColumn':
                return $this->hisFetchColumn($stmt);
            default:
                throw new \InvalidArgumentException("$fetchRule is a not valid variable of nameRule");
        }
    }

    public function hisFetch(PDOStatement $stmt, int $fetch_style = PDO::FETCH_BOTH, int $cursor_orientation =
    PDO::FETCH_ORI_NEXT, int $cursor_offset = 0)
    {
        $this->stmt = $stmt;
        try {
            return $this->stmt->fetch($fetch_style, $cursor_orientation, $cursor_offset);
        }
        catch (\Exception $e) {
            echo 'Bad get attempt _fetch: '.$e->getMessage();
        }
        return false;
    }

    public function hisFetchAll(PDOStatement $stmt, int $fetch_style = null, $fetch_argument = null, array $ctor_args = array())
    {
        $this->stmt = $stmt;

        try {
            if ($fetch_style !== PDO::FETCH_CLASS) {
                return $this->stmt->fetchAll($fetch_style, $fetch_argument);
            }
            else {
                return $this->stmt->fetchAll($fetch_style, $fetch_argument, $ctor_args);
            }
        }
        catch (\Exception $e){
            echo 'Bad get attempt _fetchAll: '.$e->getMessage();
        }
        return false;
    }

    public function hisFetchColumn(PDOStatement $stmt, int $column_number = 0)
    {
        $this->stmt = $stmt;

        try {
            return $this->stmt->fetchColumn($column_number);
        }
        catch (\Exception $e){
            echo 'Bad get attempt _fetchColumn: '.$e->getMessage();
        }
        return false;
    }

    public function hisGetColumnMeta(PDOStatement $stmt, int $column)
    {
        $this->stmt = $stmt;

        try {
            return $this->stmt->getColumnMeta($column);
        }
        catch (\Exception $e){
            echo 'Bad get attempt _getColumnMeta: '.$e->getMessage();
        }
        return false;
    }
}
