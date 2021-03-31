<?php

namespace App\Services\Comment;

use App\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class CommentCreateService
 * @property Model   $model
 * @property Comment $comment
 * @property Request $request
 * @package App\Services\Comment
 */
class CommentCreateService
{
    private Model $model;
    private Comment $comment;
    private Request $request;

    /**
     * CommentCreateService constructor.
     *
     * @param Model   $model
     * @param Comment $comment
     * @param Request $request
     */
    public function __construct(Model $model, Comment $comment, Request $request)
    {
        $this->model = $model;
        $this->comment = $comment;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->comment->text = Arr::get($data, 'text');
        $this->comment->parent_id = Arr::get($data, 'parent_id');
        $this->comment->target_class = $this->model->getMorphClass();
        $this->comment->target_id = $this->model->id;

        return $this->comment->save();
    }
}
