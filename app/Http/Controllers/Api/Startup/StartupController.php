<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Startup\StartupCreateRequest;
use App\Http\Requests\Startup\StartupUpdateRequest;
use App\Models\Startup\Startup;
use App\Repositories\Startup\StartupRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Like\LikeService;
use App\Services\Startup\StartupCreateService;
use App\Services\Startup\StartupUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class StartupController
 * @property StartupRepository $startupRepository
 * @package App\Http\Controllers\Api\Startup
 */
class StartupController extends Controller
{
    private StartupRepository $startupRepository;

    /**
     * StartupController constructor.
     *
     * @param StartupRepository $startupRepository
     */
    public function __construct(StartupRepository $startupRepository)
    {
        $this->startupRepository = $startupRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response($this->startupRepository->getParams());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->startupRepository->filters($request);

        return $this->response($builder->get());
    }

    /**
     * @param StartupCreateRequest $request
     * @param Startup              $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(StartupCreateRequest $request, Startup $startup)
    {
        DB::beginTransaction();

        try {

            if ((new StartupCreateService($startup, $request))->run()) {

                DB::commit();

                return $this->response($startup->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Startup $startup)
    {
        $builder = $this->startupRepository->findOne($request, $startup);

        return $this->response($builder->first());
    }

    /**
     * @param StartupUpdateRequest $request
     * @param Startup              $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(StartupUpdateRequest $request, Startup $startup)
    {

        DB::beginTransaction();

        try {

            if ((new StartupUpdateService($startup, $request))->run()) {

                DB::commit();

                return $this->response($startup->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Startup $startup)
    {
        $startup->delete();

        return $this->response([]);
    }
}
