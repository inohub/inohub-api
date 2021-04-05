<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment\Comment;
use App\Models\Startup\Startup;
use Illuminate\Http\Request;

class StartupCommentController extends CommentController
{
    /**
     * @param Request $request
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Startup $startup)
    {
        return parent::indexComment($request, $startup);
    }

    /**
     * @param CommentCreateRequest $request
     * @param Startup              $startup
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CommentCreateRequest $request, Startup $startup, Comment $comment)
    {
        return parent::storeComment($request, $startup, $comment);
    }

    /**
     * @param Request $request
     * @param Startup $startup
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Startup $startup, Comment $comment)
    {
        return parent::showComment($request, $startup, $comment);
    }

    /**
     * @param CommentUpdateRequest $request
     * @param Startup              $startup
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CommentUpdateRequest $request, Startup $startup, Comment $comment)
    {
        return parent::updateComment($request, $startup, $comment);
    }

    /**
     * @param Startup $startup
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Startup $startup, Comment $comment)
    {
        return parent::destroyComment($startup, $comment);
    }
}
