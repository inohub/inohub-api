<?php

namespace App\Http\Controllers\Api\Donate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donate\DonateCreateRequest;
use App\Models\Donate\Donate;
use App\Repositories\Donate\DonateRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Donate\DonateCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DonateController
 * @property DonateRepository $donateRepository
 * @package App\Http\Controllers\Api\Donate
 */
class DonateController extends Controller
{
    private DonateRepository $donateRepository;

    /**
     * DonateController constructor.
     *
     * @param DonateRepository $donateRepository
     */
    public function __construct(DonateRepository $donateRepository)
    {
        $this->donateRepository = $donateRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response([
            'fields' => $this->donateRepository->fields,
            'relations' => $this->donateRepository->relations,
        ]);
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $builder = $this->donateRepository->filters($request);

        return $this->response($builder->limit(10)->get());
    }

    /**
     * @param DonateCreateRequest $request
     * @param Donate              $donate
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(DonateCreateRequest $request, Donate $donate)
    {
        DB::beginTransaction();

        try {

            if ((new DonateCreateService($donate, $request))->run()) {

                DB::commit();

                return $this->response($donate->refresh());
            }

            return $this->response(['Не удалось сохранить'], ResponseCodes::BAD_REQUEST);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param Donate  $donate
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Donate $donate)
    {
        $builder = $this->donateRepository->filters($request, $donate);

        return $this->response($builder->get());
    }
}
