<?php

namespace Database\Seeders\Category;

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::createCategory(10);
    }

    public static function createCategory($num)
    {
        return Category::factory($num)->make()->each(function (Category $category) {
            $category->save();
            if ($category->id % 2 == 0) {
                $category->parent_id = $category->id -1;
                $category->save();
            }
        });
    }
}
