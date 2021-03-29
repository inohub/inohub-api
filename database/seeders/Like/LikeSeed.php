<?php

namespace Database\Seeders\Like;

use App\Models\Like\Like;
use App\Models\Startup\Startup;
use App\Models\StartupNews\StartupNews;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class LikeSeed
 * @package Database\Seeders\Like
 */
class LikeSeed extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            Startup::all()->each(function (Startup $startup) use ($user) {
                self::createLike($user, $startup);
            });
            StartupNews::all()->each(function (StartupNews $startupNews) use ($user){
                self::createLike($user, $startupNews);
            });
        });
    }

    /**
     * @param User  $user
     * @param Model $model
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|mixed
     */
    public static function createLike(User $user, Model $model)
    {
        return Like::factory(1)->make()->each(function (Like $like) use ($user, $model) {
            $like->owner_id = $user->id;
            $like->target_class = $model->getMorphClass();
            $like->target_id = $model->id;

            $like->save();
        });
    }
}
