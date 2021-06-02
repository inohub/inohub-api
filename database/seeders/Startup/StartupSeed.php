<?php

namespace Database\Seeders\Startup;

use App\Models\Category\Category;
use App\Models\Startup\Startup;
use App\Models\User\User;
use Illuminate\Database\Seeder;

/**
 * Class StartupSeed
 * @package Database\Seeders\Startup
 */
class StartupSeed extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            $categoriesCount = Category::query()->count();
            $category = Category::query()->where('id', rand(1, $categoriesCount))->first();
            self::createStartup($user, $category, 1);
        });
    }

    public static function createStartup(User $user, Category $category, $num)
    {
        return Startup::factory($num)->make()->each(function (Startup $startup) use ($user, $category) {
            $startup->owner_id = $user->id;
            $startup->category_id = $category->id;
            $startup->save();
        });
    }
}
