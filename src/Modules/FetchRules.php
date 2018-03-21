<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 21.03.2018
 * Time: 14:48
 */

namespace Avir\Database\Modules;


class FetchRules extends DBquery
{
    public function selectFetchRule($nameRule, $argv)
    {
        switch ($nameRule){
            case 'fetch':
                return $this->hisFetch($argv, $argv['values']);
            case 'fetchAll':
                return $this->hisFetchAll($argv, $argv['values']);
            default:
                throw new \InvalidArgumentException("$nameRule is a not valid variable of nameRule");
        }
    }

    public function hisFetch($argv, $values)
    {
        if (!$values)
        {
            $stmt = $this->getStmt($argv['query']);
            return $stmt->fetch($this->fetchOption);
        }
        return $this->stmt->fetch($this->fetchOption);
    }

    public function hisFetchAll($argv, $values)
    {
        if (!$values){
            $stmt = $this->getStmt($argv['query']);
            try {
                return $stmt->fetchAll($argv['options']);
            }
            catch (\Exception $e){
                echo 'Bad get attempt -fetchAll: '.$e->getMessage();
            }
        }
        try {
            return $this->stmt->fetchAll($argv['options']);
        }
        catch (\Exception $e){
            echo 'Bad get attempt _fetchAll: '.$e->getMessage();
        }
    }
}