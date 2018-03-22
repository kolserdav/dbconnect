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
    public function selectFetchRule($stmt, $fetchRule, $fetchOption)
    {
        $this->stmt = $stmt;

        switch ($fetchRule){
            case 'fetch':
                return $this->hisFetch($fetchOption);
            case 'fetchAll':
                return $this->hisFetchAll($fetchOption);
            default:
                throw new \InvalidArgumentException("$fetchRule is a not valid variable of nameRule");
        }
    }

    public function hisFetch($fetchOption)
    {
        try {
            return $this->stmt->fetch($fetchOption);
        }
        catch (\Exception $e) {
            echo 'Bad get attempt _fetch: '.$e->getMessage();
        }
    }

    public function hisFetchAll($fetchOption)
    {
        try {
            return $this->stmt->fetchAll($fetchOption);
        }
        catch (\Exception $e){
            echo 'Bad get attempt _fetchAll: '.$e->getMessage();
        }
        return false;
    }
}