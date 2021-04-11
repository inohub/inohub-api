<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Api\Like\LikeController;
use App\Models\Startup\Startup;
use Illuminate\Http\Request;

/**
 * Class StartupLikeController
 * @package App\Http\Controllers\Api\Startup
 */
class StartupLikeController extends LikeController
{
    /**
     * @param Request $request
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Startup $startup)
    {
        return parent::indexLike($request, $startup);
    }

    /**
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function like(Startup $startup)
    {
        return parent::modelLike($startup);
    }

    /**
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeCount(Startup $startup)
    {
        return parent::modelLikeCount($startup);
    }
}
