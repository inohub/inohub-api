<?php

namespace App\Http\Controllers\Api\Startup;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Startup\StartupCreateRequest;
use App\Http\Requests\Startup\StartupUpdateRequest;
use App\Models\Startup\Startup;
use App\Repositories\Startup\StartupRepository;
use App\Services\Startup\StartupCreateService;
use App\Services\Startup\StartupUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->startupRepository->doFilter($request);

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

            if ((new StartupCreateService($startup, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($startup->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Startup $startup)
    {
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

            if ($startup->isOwner(Auth::user()) &&
                (new StartupUpdateService($startup, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($startup->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

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
        if ($startup->isOwner(Auth::user())) {
            $startup->delete();

            return $this->response([]);
        }

        throw new FailedResultException('Не удалось удалить');

    }
}
