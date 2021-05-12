<?php

namespace App\Http\Controllers\Api\StartupNews;

use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment\Comment;
use App\Models\StartupNews\StartupNews;
use Illuminate\Http\Request;

/**
 * Class StartupNewsCommentController
 * @package App\Http\Controllers\Api\StartupNews
 */
class StartupNewsCommentController extends CommentController
{
    /**
     * @param Request     $request
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, StartupNews $startupNews)
    {
        return parent::indexComment($request, $startupNews);
    }

    /**
     * @param CommentCreateRequest $request
     * @param StartupNews          $startupNews
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CommentCreateRequest $request, StartupNews $startupNews, Comment $comment)
    {
        return parent::storeComment($request, $startupNews, $comment);
    }

    /**
     * @param StartupNews $startupNews
     * @param Comment     $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\WrongDataException
     */
    public function show(StartupNews $startupNews, Comment $comment)
    {
        return parent::showComment($startupNews, $comment);
    }

    /**
     * @param CommentUpdateRequest $request
     * @param StartupNews          $startupNews
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CommentUpdateRequest $request, StartupNews $startupNews, Comment $comment)
    {
        return parent::updateComment($request, $startupNews, $comment);
    }

    /**
     * @param StartupNews $startupNews
     * @param Comment     $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(StartupNews $startupNews, Comment $comment)
    {
        return parent::destroyComment($startupNews, $comment);
    }
}
