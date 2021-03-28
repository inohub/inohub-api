<?php

namespace App\Services\Like;

use App\Models\Like\Like;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LikeCreateService
 * @property Model $model
 * @property Like  $like
 * @package App\Services\Like
 */
class LikeCreateService
{
    private Model $model;
    private Like $like;

    /**
     * LikeCreateService constructor.
     *
     * @param Model $model
     * @param Like  $like
     */
    public function __construct(Model $model, Like $like)
    {
        $this->model = $model;
        $this->like = $like;
    }

    public function run()
    {
        $this->like->target_class = $this->model->getMorphClass();
        $this->like->target_id = $this->model->id;

        return $this->like->save();
    }
}
