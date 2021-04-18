<?php

namespace App\Models\Like\Checker;

use App\Models\Like\Like;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LikeChecker
 * @property Like $like
 * @package App\Models\Like\Checker
 */
class LikeChecker
{
    private Like $like;

    /**
     * LikeChecker constructor.
     *
     * @param Like $like
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isOwner(User $user)
    {
        return $this->like->owner_id == $user->id;
    }

    /**
     * @param Model $model
     *
     * @return bool
     */
    public function isParent(Model $model)
    {
        $res = $this->like->target_class == $model->getMorphClass();

        return $res && $this->like->target_id == $model->id;
    }
}
