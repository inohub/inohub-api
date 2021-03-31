<?php

namespace App\Services\Comment;

use App\Models\Comment\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class CommentUpdateService
 * @property Comment $comment
 * @property Request $request
 * @package App\Services\Comment
 */
class CommentUpdateService
{
    private Comment $comment;
    private Request $request;

    /**
     * CommentUpdateService constructor.
     *
     * @param Comment $comment
     * @param Request $request
     */
    public function __construct(Comment $comment, Request $request)
    {
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

        return $this->comment->save();
    }
}
