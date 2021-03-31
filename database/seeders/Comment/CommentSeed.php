<?php

namespace Database\Seeders\Comment;

use App\Models\Comment\Comment;
use App\Models\Startup\Startup;
use App\Models\StartupNews\StartupNews;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class CommentSeed
 * @package Database\Seeders\Comment
 */
class CommentSeed extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            Startup::all()->each(function (Startup $startup) use ($user) {
                self::createComment($user, $startup);
            });
            StartupNews::all()->each(function (StartupNews $startupNews) use ($user) {
                self::createComment($user, $startupNews);
            });
        });
    }

    /**
     * @param User  $user
     * @param Model $model
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|mixed
     */
    public static function createComment(User $user, Model $model)
    {
        return Comment::factory(1)->make()->each(function (Comment $comment) use ($user, $model) {
            $comment->owner_id = $user->id;
            $comment->target_class = $model->getMorphClass();
            $comment->target_id = $model->id;

            $comment->save();
        });
    }
}
