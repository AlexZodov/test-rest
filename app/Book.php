<?php

namespace App;

use App\Interfaces\IModelQueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model implements IModelQueable
{
    use SoftDeletes;
    protected $fillable = ['id','title', 'author_id', 'category_id'];

    public function author(){
        return $this->belongsTo(Author::class,'author_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public static function store($payload){ //separate method for any possible pre-saving proccessing logic
        $instance = self::create($payload);

        return $instance;
    }

    public static function processQueryParameters(array $params)
    {
        $query = self::query()->select(['books.id','books.title','authors.name_prefix','authors.first_name','authors.last_name','categories.name'])
            ->leftJoin('authors', 'authors.id', '=', 'books.author_id')
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id');
        //used JOINs because they are faster then laravel native relations(they make additional sub-query for existence checking)
        $bookInst = new self();
        $authorInst = new Author();
        $authorColumns = $authorInst->getFillable();
        $categoryInst = new Category();
        $categoryColumns = $categoryInst->getFillable();

        if(isset($params['start'],$params['length'])){
            $query->skip($params['start'])->take($params['length']);
        }

        if(isset($params['search'])) {

            foreach ($params['search'] as $column => $search) {
                if (in_array($column, $bookInst->fillable)) {
                    $operator = (is_string($search)) ? 'LIKE' : '=';
                    $searchValue = (is_string($search)) ? '%' . $search . '%' : $search;
                    $query->where('books.' . $column, $operator, $searchValue);

                } elseif (in_array($column, $authorColumns)) {
                    $operator = (is_string($search)) ? 'LIKE' : '=';
                    $searchValue = (is_string($search)) ? '%' . $search . '%' : $search;
                    $query->where('authors.' . $column, $operator, $searchValue);
                } elseif (in_array($column, $categoryColumns)) {
                    $operator = (is_string($search)) ? 'LIKE' : '=';
                    $searchValue = (is_string($search)) ? '%' . $search . '%' : $search;
                    $query->where('categories.' . $column, $operator, $searchValue);
                }
            }
        }

        if(isset($params['order'])){
            $column = $params['order']['column'];
            $direction = $params['order']['dir'];
            if (in_array($column, $bookInst->fillable) ||
                in_array($column, $authorColumns) ||
                in_array($column, $categoryColumns)) {
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
