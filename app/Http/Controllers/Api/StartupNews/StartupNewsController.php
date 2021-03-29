<?php

namespace App\Http\Controllers\Api\StartupNews;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartupNews\StartupNewsCreateRequest;
use App\Http\Requests\StartupNews\StartupNewsUpdateRequest;
use App\Models\Startup\Startup;
use App\Models\StartupNews\StartupNews;
use App\Repositories\StartupNews\StartupNewsRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Like\LikeService;
use App\Services\StartupNews\StartupNewsCreateService;
use App\Services\StartupNews\StartupNewsUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class StartupNewsController
 * @property StartupNewsRepository $startupNewsRepository
 * @package App\Http\Controllers\Api\StartupNews
 */
class StartupNewsController extends Controller
{
    private StartupNewsRepository $startupNewsRepository;

    /**
     * StartupNewsController constructor.
     *
     * @param StartupNewsRepository $startupNewsRepository
     */
    public function __construct(StartupNewsRepository $startupNewsRepository)
    {
        $this->startupNewsRepository = $startupNewsRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response([
            'fields'    => $this->startupNewsRepository->fields,
            'relations' => $this->startupNewsRepository->relations,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->startupNewsRepository->filters($request);

        return $this->response($builder->get());
    }

    /**
     * @param StartupNewsCreateRequest $request
     * @param StartupNews              $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(StartupNewsCreateRequest $request, StartupNews $startupNews)
    {
        DB::beginTransaction();

        try {

            if ((new StartupNewsCreateService($startupNews, $request))->run()) {

                DB::commit();

                return $this->response($startupNews->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request     $request
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, StartupNews $startupNews)
    {
        $builder = $this->startupNewsRepository->filters($request, $startupNews);

        return $this->response($builder->get());
    }

    /**
     * @param StartupNewsUpdateRequest $request
     * @param StartupNews              $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(StartupNewsUpdateRequest $request, StartupNews $startupNews)
    {
        DB::beginTransaction();

        try {

            if ((new StartupNewsUpdateService($startupNews, $request))->run()) {

                DB::commit();

                return $this->response($startupNews->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(StartupNews $startupNews)
    {
        $startupNews->delete();

        return $this->response([]);
    }

    /**
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function like(StartupNews $startupNews)
    {
        DB::beginTransaction();

        try {

            if ((new LikeService($startupNews, Auth::user()))->run()) {

                DB::commit();

                return $this->response($startupNews->likes()->count());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }
}
