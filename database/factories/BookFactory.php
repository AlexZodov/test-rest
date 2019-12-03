<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    $authorIds = App\Author::select('id')->get();
    $authorId = $faker->randomElement($authorIds)->id;

    $categoryIds = App\Category::select('id')->get();
    $categoryId = $faker->randomElement($categoryIds)->id;

    return [
        //
        'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'author_id'=>$authorId,
        'category_id'=>$categoryId
    ];
});
