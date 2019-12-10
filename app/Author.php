<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','first_name','last_name','name_prefix'];
    //
    public function books(){
        return $this->hasMany(Book::class,'author_id','id');
    }

    public static function getFullConnectionName()
    {
        return env('DB_CONNECTION','mysql').'.authors';
    }

    public static function getFillableFields(){
        $inst = new static;
        $fillable = [];
        foreach ($inst->getFillable() as $item) {
            $fillable[] = 'authors.'.$item;
        }

        return $fillable;
    }

}
