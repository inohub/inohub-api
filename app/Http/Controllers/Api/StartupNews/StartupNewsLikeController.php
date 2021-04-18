<?php

namespace App\Http\Controllers\Api\StartupNews;

use App\Http\Controllers\Api\Like\LikeController;
use App\Models\StartupNews\StartupNews;
use Illuminate\Http\Request;

/**
 * Class StartupNewsLikeController
 * @package App\Http\Controllers\Api\StartupNews
 */
class StartupNewsLikeController extends LikeController
{
    /**
     * @param Request     $request
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, StartupNews $startupNews)
    {
        return parent::indexLike($request, $startupNews);
    }

    /**
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function like(StartupNews $startupNews)
    {
        return parent::modelLike($startupNews);
    }

    /**
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeCount(StartupNews $startupNews)
    {
        return parent::modelLikeCount($startupNews);
    }
}
