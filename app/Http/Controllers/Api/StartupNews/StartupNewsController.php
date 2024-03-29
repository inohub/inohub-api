<?php

namespace App\Http\Controllers\Api\StartupNews;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StartupNews\StartupNewsCreateRequest;
use App\Http\Requests\StartupNews\StartupNewsUpdateRequest;
use App\Models\Startup\Startup;
use App\Models\StartupNews\StartupNews;
use App\Repositories\StartupNews\StartupNewsRepository;
use App\Services\StartupNews\StartupNewsCreateService;
use App\Services\StartupNews\StartupNewsUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @param  Request  $request
     * @param  Startup  $startup
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Startup $startup)
    {
        $builder = $this->startupNewsRepository->doFilter($request)
            ->where('startup_id', $startup->id);

        return $this->response($builder->customPaginate());
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

            if ((new StartupNewsCreateService($startupNews, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($startupNews->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param StartupNews $startupNews
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(StartupNews $startupNews)
    {
        return $this->response($startupNews);
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

            if ($startupNews->startup->isOwner(Auth::user()) &&
                (new StartupNewsUpdateService($startupNews, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($startupNews->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

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
        if ($startupNews->startup->isOwner(Auth::user())) {

            $startupNews->delete();

            return $this->response([]);
        }

        throw new FailedResultException('Не удалось удалить');
    }
}
