<?php

namespace App\Services\Comment;

use App\Components\Request\DataTransfer;
use App\Models\Comment\Comment;

/**
 * Class CommentUpdateService
 * @property Comment      $comment
 * @property DataTransfer $request
 * @package App\Services\Comment
 */
class CommentUpdateService
{
    private Comment $comment;
    private DataTransfer $request;

    /**
     * CommentUpdateService constructor.
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

        return $this->comment->save();
    }
}
