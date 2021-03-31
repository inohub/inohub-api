<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment\Comment;
use App\Models\Startup\Startup;
use App\Repositories\Comment\CommentRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Comment\CommentCreateService;
use App\Services\Comment\CommentUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class StartupCommentController
 * @property CommentRepository $commentRepository
 * @package App\Http\Controllers\Api\Startup
 */
class StartupCommentController extends Controller
{
    private CommentRepository $commentRepository;

    /**
     * StartupCommentController constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param Startup $startup
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Startup $startup, Request $request)
    {
        $builder = $this->commentRepository->filters($request, $startup);

        return $this->response($builder->get());
    }

    /**
     * @param Startup              $startup
     * @param CommentCreateRequest $request
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Startup $startup, CommentCreateRequest $request, Comment $comment)
    {
        DB::beginTransaction();

        try {

            if ((new CommentCreateService($startup, $comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response(['Не удалось сохранить'], ResponseCodes::BAD_REQUEST);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Startup $startup
     * @param Request $request
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Startup $startup, Request $request, Comment $comment)
    {
        $builder = $this->commentRepository->filters($request, $startup, $comment);

        return $this->response($builder->get());
    }

    /**
     * @param Startup              $startup
     * @param CommentUpdateRequest $request
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Startup $startup, CommentUpdateRequest $request, Comment $comment)
    {
        DB::beginTransaction();

        try {

            if ($comment->getChecker()->isOwner(Auth::user()) &&
                $comment->getChecker()->isParent($startup) &&
                (new CommentUpdateService($comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response(['Не удалось обновить'], ResponseCodes::BAD_REQUEST);

        } catch (\Throwable $exception) {

            throw $exception;
        }
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
        if ($comment->getChecker()->isOwner(Auth::user()) &&
            $comment->getChecker()->isParent($startup)) {
            $comment->delete();
        }

        return $this->response([]);
    }
}
