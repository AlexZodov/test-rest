<?php


namespace App\Repositories;


use App\Author;
use Illuminate\Database\Eloquent\Model;

class AuthorRepository extends BaseRepository
{

    protected $model;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

}
