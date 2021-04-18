<?php

namespace App\Http\Controllers\Api\Like;

use App\Http\Controllers\Controller;
use App\Repositories\Like\LikeRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Like\LikeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class LikeController
 * @property LikeRepository $likeRepository
 * @package App\Http\Controllers\Api\Like
 */
class LikeController extends Controller
{
    private LikeRepository $likeRepository;

    /**
     * LikeController constructor.
     *
     * @param LikeRepository $likeRepository
     */
    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response($this->likeRepository->getParams());
    }

    /**
     * @param Request $request
     * @param Model   $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function indexLike(Request $request, Model $model)
    {
        $builder = $this->likeRepository->filters($request)
            ->where('target_class', $model->getMorphClass())
            ->where('target_id', $model->id);

        return $this->response($builder->get());
    }

    /**
     * @param Model $model
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    protected function modelLike(Model $model)
    {
        DB::beginTransaction();

        try {

            if ((new LikeService($model, Auth::user()))->run()) {

                DB::commit();

                return $this->response([
                    'like_count' => $model->likes()->count()
                ]);
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Model $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelLikeCount(Model $model)
    {
        return $this->response([
            'like_count' => $model->likes()->count()
        ]);
    }
}
