<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Author::truncate();
        \App\Category::truncate();
        \App\Book::truncate();

        $authors = factory(\App\Author::class,10)->create();
        $categories = factory(App\Category::class,10)->create();

        $books = factory(App\Book::class,50)->create();
    }
}
