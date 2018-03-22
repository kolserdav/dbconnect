<?php
/**
 * Created by kolserdav
 * User: Sergey Kol'miller
 * Date: 21.03.2018
 * Time: 14:48
 */

namespace Avir\Database\Modules;


class FetchRules extends DB
{
    public function selectFetchRule($nameRule, $args)
    {
        $this->stmt = $this->getStmt($args['query'], $args['values']);
        if (!empty($args['values'])){
            $args['valuesOn'] = true;
        }
        switch ($nameRule){
            case 'fetch':
                return $this->hisFetch($args, $args['valuesOn']);
            case 'fetchAll':
                return $this->hisFetchAll($args, $args['valuesOn']);
            default:
                throw new \InvalidArgumentException("$nameRule is a not valid variable of nameRule");
        }
    }

    public function hisFetch($argv, $valuesOn = false)
    {
        if (!$valuesOn)
        {
            $stmt = $this->getStmt($argv['query']);
            return $stmt->fetch($argv['fetchOption']);
        }
        return $this->stmt->fetch($argv['fetchOption']);
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