<?php

namespace App;

use App\Interfaces\IModelQueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','name'];
    //
    public function books(){
        return $this->hasMany(Book::class,'category_id','id');
    }

    public static function getFullConnectionName()
    {
        return env('DB_CONNECTION','mysql').'.categories';
    }

    public static function getFillableFields(){
        $inst = new static;
        $fillable = [];
        foreach ($inst->getFillable() as $item) {
            $fillable[] = 'categories.'.$item;
        }

        return $fillable;
    }
}
