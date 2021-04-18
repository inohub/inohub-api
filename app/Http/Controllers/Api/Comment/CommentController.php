<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Repositories\Comment\CommentRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Comment\CommentCreateService;
use App\Services\Comment\CommentUpdateService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return $this->response($this->commentRepository->getParams());
    }

    /**
     * @param Request $request
     * @param Model   $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function indexComment(Request $request, Model $model)
    {
        $builder = $this->commentRepository->filters($request)
            ->where('target_class', $model->getMorphClass())
            ->where('target_id', $model->id);

        return $this->response($builder->get());
    }

    /**
     * @param Request $request
     * @param Model   $model
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    protected function storeComment(Request $request, Model $model, Comment $comment)
    {
        DB::beginTransaction();

        try {

            if ((new CommentCreateService($model, $comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param Model   $model
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showComment(Request $request, Model $model, Comment $comment)
    {
        $builder = $this->commentRepository->findOne($request, $comment)
            ->where('target_class', $model->getMorphClass())
            ->where('target_id', $model->id);

        return $this->response($builder->first());
    }

    /**
     * @param Request $request
     * @param Model   $model
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    protected function updateComment(Request $request, Model $model, Comment $comment)
    {
        DB::beginTransaction();

        try {

            if ($comment->getChecker()->isOwner(Auth::user()) &&
                $comment->getChecker()->isParent($model) &&
                (new CommentUpdateService($comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Model   $model
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    protected function destroyComment(Model $model, Comment $comment)
    {
        if ($comment->getChecker()->isOwner(Auth::user()) &&
            $comment->getChecker()->isParent($model)) {

            $comment->delete();

            return $this->response([]);
        }

        return $this->response([], ResponseCodes::FAILED_RESULT);
    }
}
