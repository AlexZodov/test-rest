<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','title', 'author_id', 'category_id'];

    public function author(){
        return $this->belongsTo(Author::class,'author_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public static function getFillableFields(){
        $inst = new static;
        $fillable = [];
        foreach ($inst->getFillable() as $item) {
            $fillable[] = 'books.'.$item;
        }

        return $fillable;
    }
}
