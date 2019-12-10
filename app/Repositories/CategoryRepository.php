<?php


namespace App\Repositories;


use App\Author;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository
{

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

}
