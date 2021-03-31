<?php

namespace App\Http\Controllers\Api\StartupNews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment\Comment;
use App\Models\StartupNews\StartupNews;
use App\Repositories\Comment\CommentRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Comment\CommentCreateService;
use App\Services\Comment\CommentUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class StartupNewsCommentController
 * @property CommentRepository $commentRepository
 * @package App\Http\Controllers\Api\StartupNews
 */
class StartupNewsCommentController extends Controller
{
    private CommentRepository $commentRepository;

    /**
     * StartupNewsCommentController constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param StartupNews $startupNews
     * @param Request     $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(StartupNews $startupNews, Request $request)
    {
        $builder = $this->commentRepository->filters($request, $startupNews);

        return $this->response($builder->get());
    }

    /**
     * @param StartupNews          $startupNews
     * @param CommentCreateRequest $request
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(StartupNews $startupNews, CommentCreateRequest $request, Comment $comment)
    {
        DB::beginTransaction();

        try {

            if ((new CommentCreateService($startupNews, $comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response(['Не удалось сохранить'], ResponseCodes::BAD_REQUEST);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param StartupNews $startupNews
     * @param Request     $request
     * @param Comment     $comment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(StartupNews $startupNews, Request $request, Comment $comment)
    {
        $builder = $this->commentRepository->filters($request, $startupNews, $comment);

        return $this->response($builder->get());
    }

    /**
     * @param StartupNews          $startupNews
     * @param CommentUpdateRequest $request
     * @param Comment              $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(StartupNews $startupNews, CommentUpdateRequest $request, Comment $comment)
    {
        DB::beginTransaction();

        try {

            if ($comment->getChecker()->isOwner(Auth::user()) &&
                $comment->getChecker()->isParent($startupNews) &&
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
     * @param StartupNews $startupNews
     * @param Comment     $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(StartupNews $startupNews, Comment $comment)
    {
        if ($comment->getChecker()->isOwner(Auth::user()) &&
            $comment->getChecker()->isParent($startupNews)) {
            $comment->delete();

            return $this->response([]);
        }

        return $this->response(['Не удалось удалить'], ResponseCodes::BAD_REQUEST);
    }
}
