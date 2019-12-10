<?php


namespace App\Repositories;


use App\Author;
use App\Book;
use App\Category;
use App\Repositories\Traits\Joinable;

class BookRepository extends BaseRepository
{
    use Joinable;

    protected $model;

    protected $joins = [
        'authors' =>[
            'authors.id',
            '=',
            'books.author_id',
            'left'
        ],
        'categories' => [
            'categories.id',
            '=',
            'books.category_id',
            'left'
        ]
    ];

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function parametrizedResult(array $whereConditions = [], array $orderConditions = [], $start = null, $length = null)
    {
        $fillable = $this->model->getFillableFields();

        $authorColumns = Author::getFillableFields();
        $categoryColumns = Category::getFillableFields();

        $query = $this->model->select(array_merge($fillable,['authors.first_name','authors.last_name','authors.name_prefix','categories.name']));

        $this->prepareJoins($query);

        if(isset($start,$length)){
            $query->skip($start)->take($length);
        }

        if(isset($whereConditions)) {

            foreach ($whereConditions as $column => $search) {
                $operatorAndValue = $this->resolveOperatorAndValue($search);

                if (in_array('books.'.$column, $fillable)) {
                    $query->where('books.'.$column, $operatorAndValue['operator'], $operatorAndValue['value']);
                } elseif (in_array('authors.'.$column, $authorColumns)) {
                    $query->where('authors.'.$column, $operatorAndValue['operator'], $operatorAndValue['value']);
                }elseif(in_array('categories.'.$column, $categoryColumns)){
                    $query->where('categories.'.$column, $operatorAndValue['operator'], $operatorAndValue['value']);
                }

            }
        }

        if(!blank($orderConditions)){
            $column = $orderConditions['column'];
            $direction = $orderConditions['dir'];

            if (in_array($column, $fillable)) {
                if($direction==='desc'||$direction==='DESC'){
                    $query->orderByDesc($column);
                }elseif($direction==='asc'||$direction==='ASC'){
                    $query->orderBy($column);
                }else{
                    $query->orderBy($column);
                }
            }

        }

        return $query->get();
    }

}
