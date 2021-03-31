<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\Request;

/**
 * Class CommentController
 * @property CommentRepository $commentRepository
 * @package App\Http\Controllers\Api\Comment
 */
class CommentController extends Controller
{
    private CommentRepository $commentRepository;

    /**
     * CommentController constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response([
            'fields' => $this->commentRepository->fields,
            'relations' => $this->commentRepository->relations,
        ]);
    }
}
