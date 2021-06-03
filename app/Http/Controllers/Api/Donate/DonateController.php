<?php

namespace App\Http\Controllers\Api\Donate;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Donate\DonateCreateRequest;
use App\Models\Donate\Donate;
use App\Repositories\Donate\DonateRepository;
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
     * @param Request $request
     */
    public function index(Request $request)
    {
        $builder = $this->donateRepository->doFilter($request);

        return $this->response($builder->customPaginate());
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

            $user = \Auth::user();
            $payment = $user->charge($request->post('amount'), $request->post('payment_method_id'));
            $payment = $payment->asStripePaymentIntent();

            if ($payment->status == 'succeeded' &&
                (new DonateCreateService($donate, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($donate->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Donate $donate
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Donate $donate)
    {
        return $this->response($donate);
    }
}
