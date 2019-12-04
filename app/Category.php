<?php

namespace App;

use App\Interfaces\IModelQueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements IModelQueable
{
    use SoftDeletes;

    protected $fillable = ['id','name'];
    //
    public function books(){
        return $this->hasMany(Book::class,'category_id','id');
    }

    public static function store($payload){ //separate method for any possible pre-saving proccessing logic
        $instance = self::create($payload);

        return $instance;
    }

    public static function getFullConnectionName()
    {
        return env('DB_CONNECTION','mysql').'.categories';
    }

    public static function processQueryParameters(array $params)
    {
        $query = self::query()->select(['categories.id','categories.name']);

        $categoryInst = new self();


        if(isset($params['start'],$params['length'])){
            $query->skip($params['start'])->take($params['length']);
        }

        if(isset($params['search'])) {

            foreach ($params['search'] as $column => $search) {
                if (in_array($column, $categoryInst->fillable)) {
                    $operator = (is_string($search)) ? 'LIKE' : '=';
                    $searchValue = (is_string($search)) ? '%' . $search . '%' : $search;
                    $query->where('categories.' . $column, $operator, $searchValue);
                }
            }
        }

        if(isset($params['order'])){
            $column = $params['order']['column'];
            $direction = $params['order']['dir'];
            if (in_array($column, $categoryInst->fillable)) {
                if($direction==='desc'||$direction==='DESC'){
                    $query->orderByDesc($column);
                }elseif($direction==='asc'||$direction==='ASC'){
                    $query->orderBy($column);
                }else{
                    $query->orderBy($column);
                }
            }

        }


        return $query;
    }
}
