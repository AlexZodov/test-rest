<?php


namespace App\Repositories\Traits;


trait Joinable
{
    private function prepareJoins($queryChain){
        $query = $queryChain;
        foreach ($this->joins as $key => $join) {
            switch ($join[3]){
                case 'left':{
                    $query->leftJoin($key,$join[0], $join[1], $join[2])/*->where($key.'.deleted_at',null)*/;
                    break;
                }
                case 'right':{
                    $query->rightJoin($key,$join[0], $join[1], $join[2])/*->where($key.'.deleted_at',null)*/;
                    break;
                }
                default:{
                    $query->join($key,$join[0], $join[1], $join[2])/*->where($key.'.deleted_at',null)*/;
                    break;
                }
            }


        }
        return $query;
    }

}
