<?php

namespace App\Services\Comment;

use App\Components\Request\DataTransfer;
use App\Models\Comment\Comment;

/**
 * Class CommentCreateService
 * @property Comment      $comment
 * @property DataTransfer $request
 * @package App\Services\Comment
 */
class CommentCreateService
{
    private Comment $comment;
    private DataTransfer $request;

    /**
     * CommentCreateService constructor.
     *
     * @param Comment      $comment
     * @param DataTransfer $request
     */
    public function __construct(Comment $comment, DataTransfer $request)
    {
        $this->comment = $comment;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->comment->text = $this->request->post('text');
        $this->comment->parent_id = $this->request->post('parent_id');
        $this->comment->target_class = $this->request->post('model')->getMorphClass();
        $this->comment->target_id = $this->request->post('model')->id;

        return $this->comment->save();
    }
}
