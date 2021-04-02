<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentCreateRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Models\Comment\Comment;
use App\Models\Startup\Startup;
use App\Repositories\Comment\CommentRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Comment\CommentCreateService;
use App\Services\Comment\CommentUpdateService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentableController
 * @property CommentRepository $commentRepository
 * @package App\Http\Controllers\Api\Comment
 */
class CommentableController extends Controller
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function index(Request $request, Model $model = null)
    {
        $builder = $this->commentRepository->filters($request, $model);

        return $this->response($builder->get());
    }

    public function store(CommentCreateRequest $request, Comment $comment, Model $model = null)
    {
        DB::beginTransaction();

        try {

            if ((new CommentCreateService($model, $comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response([], ResponseCodes::BAD_REQUEST);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    public function show(Request $request, Comment $comment, Model $model = null)
    {
        $builder = $this->commentRepository->filters($request, $model, $comment);

        return $this->response($builder->get());
    }

    public function update(CommentUpdateRequest $request, Comment $comment, Model $model = null)
    {
        DB::beginTransaction();

        try {

            if ($comment->getChecker()->isOwner(Auth::user()) &&
                $comment->getChecker()->isParent($model) &&
                (new CommentUpdateService($comment, $request))->run()) {

                DB::commit();

                return $this->response($comment->refresh());
            }

            return $this->response([], ResponseCodes::BAD_REQUEST);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    public function destroy(Comment $comment, Model $model = null)
    {
        if ($comment->getChecker()->isOwner(Auth::user()) &&
            $comment->getChecker()->isParent($model)) {

            $comment->delete();

            return $this->response([]);
        }

        return $this->response([], ResponseCodes::BAD_REQUEST);
    }
}
