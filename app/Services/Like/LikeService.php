<?php

namespace App\Services\Like;

use App\Components\Request\DataTransfer;
use App\Models\Like\Like;
use App\Models\User\User;

/**
 * Class LikeService
 * @property User         $user
 * @property DataTransfer $request
 * @package App\Services\Like
 */
class LikeService
{
    private User $user;
    private DataTransfer $request;

    /**
     * LikeService constructor.
     *
     * @param User         $user
     * @param DataTransfer $request
     */
    public function __construct(User $user, DataTransfer $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $checker = $this->request->post('model')->getChecker()->checkLike($this->user);

        if ($checker->exists()) {

            $res = $checker->first()->delete();

        } else {

            $like = new Like();
            $like->target_class = $this->request->post('model')->getMorphClass();
            $like->target_id = $this->request->post('model')->id;

            $res = $like->save();
        }

        return $res;
    }
}
