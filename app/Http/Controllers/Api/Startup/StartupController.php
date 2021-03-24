<?php

namespace App\Http\Controllers\Api\Startup;

use App\Http\Controllers\Controller;
use App\Http\Fields\Startup\StartupFields;
use App\Http\Requests\Startup\StartupCreateRequest;
use App\Http\Requests\Startup\StartupUpdateRequest;
use App\Models\Startup\Startup;
use App\Repositories\Startup\StartupRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Startup\StartupCreateService;
use App\Services\Startup\StartupUpdateService;
use Illuminate\Http\Request;
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
        return $this->response([StartupFields::fields(), StartupFields::relations()]);
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

                $startup->setVisible(StartupFields::fields());

                return $this->response($startup->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Startup $startup, Request $request)
    {
        $startup->setResponseFields($request);

        return $this->response($startup);
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

                $startup->setVisible(StartupFields::fields());

                return $this->response($startup->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

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
