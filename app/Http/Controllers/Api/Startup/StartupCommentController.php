<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Api\Comment\CommentableController;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment\Comment;
use App\Models\Startup\Startup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StartupCommentController extends CommentableController
{
    /**
     * @param Request      $request
     * @param Model|null   $model
     * @param Startup|null $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Model $model = null, Startup $startup = null)
    {
        return parent::index($request, $model);
    }

    /**
     * @param CommentCreateRequest $request
     * @param Comment              $comment
     * @param Model|null           $model
     * @param Startup|null         $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CommentCreateRequest $request, Comment $comment, Model $model = null, Startup $startup = null)
    {
        return parent::store($request, $comment, $model);
    }

    /**
     * @param Request      $request
     * @param Comment      $comment
     * @param Model|null   $model
     * @param Startup|null $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Comment $comment, Model $model = null, Startup $startup = null)
    {
        return parent::show($request, $comment, $model);
    }

    /**
     * @param CommentUpdateRequest $request
     * @param Comment              $comment
     * @param Model|null           $model
     * @param Startup|null         $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CommentUpdateRequest $request, Comment $comment, Model $model = null, Startup $startup = null)
    {
        return parent::update($request, $comment, $model);
    }

    /**
     * @param Comment      $comment
     * @param Model|null   $model
     * @param Startup|null $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment, Model $model = null, Startup $startup = null)
    {
        return parent::destroy($comment, $model);
    }
}
