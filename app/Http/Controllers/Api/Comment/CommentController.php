<?php

namespace App\Http\Controllers\Api\Comment;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Exceptions\WrongDataException;
use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Repositories\Comment\CommentRepository;
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
     * @param Request $request
     * @param Model   $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function indexComment(Request $request, Model $model)
    {
        $builder = $this->commentRepository->doFilter($request)
            ->where('target_class', $model->getMorphClass())
            ->where('target_id', $model->id);

        return $this->response($builder->customPaginate());
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

        $data = $request->post();
        $data['model'] = $model;

        try {

            if ((new CommentCreateService($comment, new DataTransfer($data)))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Model   $model
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws WrongDataException
     */
    protected function showComment(Model $model, Comment $comment)
    {
        if ($comment->getChecker()->isParent($model)) {
            return $this->response($comment);
        }

        throw new WrongDataException("This model doesn't have this comment");
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

            if ($comment->isOwner(Auth::user()) &&
                $comment->getChecker()->isParent($model) &&
                (new CommentUpdateService($comment, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

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
        if ($comment->isOwner(Auth::user()) &&
            $comment->getChecker()->isParent($model)) {

            $comment->delete();

            return $this->response([]);
        }

        throw new FailedResultException('Не удалось сохранить');
    }
}
