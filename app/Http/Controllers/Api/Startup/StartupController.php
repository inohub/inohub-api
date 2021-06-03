<?php

namespace App\Http\Controllers\Api\Startup;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Startup\StartupBlockRequest;
use App\Http\Requests\Startup\StartupCreateRequest;
use App\Http\Requests\Startup\StartupUpdateRequest;
use App\Models\Startup\Startup;
use App\Repositories\Startup\StartupRepository;
use App\Services\Startup\StartupChangeStatusService;
use App\Services\Startup\StartupCreateService;
use App\Services\Startup\StartupUpdateService;
use App\StartupStatus\StartupStatus;
use App\UserRole\UserRole;
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

        $this->middleware('rbac:is,' . UserRole::ADMIN)->only('approve');
        $this->middleware('rbac:is,' . UserRole::ADMIN)->only('block');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->startupRepository->doFilter($request);

        return $this->response($builder->customPaginate());
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
                $startup->status == StartupStatus::DRAFT &&
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

    /**
     * @param Startup $startup
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResultException
     * @throws \Throwable
     */
    public function publish(Startup $startup)
    {
        DB::beginTransaction();

        try {

            if ($startup->isOwner(Auth::user()) &&
                $startup->status != StartupStatus::PUBLISH &&
                (new StartupChangeStatusService($startup, new DataTransfer(['status' => StartupStatus::PUBLISH])))->run()) {

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
     * @throws FailedResultException
     * @throws \Throwable
     */
    public function approve(Startup $startup)
    {
        DB::beginTransaction();

        try {

            if ($startup->status != StartupStatus::APPROVE &&
                (new StartupChangeStatusService($startup, new DataTransfer(['status' => StartupStatus::APPROVE])))->run()) {

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
     * @throws FailedResultException
     * @throws \Throwable
     */
    public function archive(Startup $startup)
    {
        DB::beginTransaction();

        try {

            if ($startup->isOwner(Auth::user()) &&
                $startup->status != StartupStatus::ARCHIVE &&
                (new StartupChangeStatusService($startup, new DataTransfer(['status' => StartupStatus::ARCHIVE])))->run()) {

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
     * @throws FailedResultException
     * @throws \Throwable
     */
    public function block(Startup $startup, StartupBlockRequest $request)
    {
        DB::beginTransaction();

        try {

            if ($startup->status != StartupStatus::BLOCK &&
                (new StartupChangeStatusService($startup, new DataTransfer([
                    'status'       => StartupStatus::BLOCK,
                    'block_reason' => $request->post('block_reason'),
                ])))->run()) {

                DB::commit();

                return $this->response($startup->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }
}
