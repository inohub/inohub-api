<?php

namespace App\Services\Like;

use App\Models\Like\Like;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LikeService
 * @property Model $model
 * @property User  $user
 * @package App\Services\Like
 */
class LikeService
{
    private Model $model;
    private User $user;

    /**
     * LikeService constructor.
     *
     * @param Model $model
     * @param User  $user
     */
    public function __construct(Model $model, User $user)
    {
        $this->model = $model;
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $checker = $this->model->getChecker()->checkLike($this->user);

        if ($checker->exists()) {

            $res = $checker->first()->delete();

        } else {

            $like = new Like();
            $like->target_class = $this->model->getMorphClass();
            $like->target_id = $this->model->id;

            $res = $like->save();
        }

        return $res;
    }
}
