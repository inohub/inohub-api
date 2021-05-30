<?php

namespace App\Models\Comment\Checker;

use App\Models\Comment\Comment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommentChecker
 * @property Comment $comment
 * @package App\Models\Comment\Checker
 */
class CommentChecker
{
    private Comment $comment;

    /**
     * CommentChecker constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param Model $model
     *
     * @return bool
     */
    public function isParent(Model $model)
    {
        $res = $this->comment->target_class == $model->getMorphClass();

        return $res && $this->comment->target_id == $model->id;
    }
}
