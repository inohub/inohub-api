<?php

namespace App\Http\Controllers\Api\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqCreateRequest;
use App\Models\Faq\Faq;
use App\Repositories\Faq\FaqRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Faq\FaqCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FaqController extends Controller
{
    private FaqRepository $faqRepository;

    /**
     * StartupController constructor.
     *
     * @param FaqRepository $faqRepository
     */
    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response([
            'fields' => $this->faqRepository->fields,
            'relations' => $this->faqRepository->relations
        ]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->faqRepository->filters($request);

        return $this->response($builder->get());
    }

    /**
     * @param  FaqCreateRequest  $request
     * @param  Faq  $faq
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(FaqCreateRequest $request, Faq $faq)
    {
        DB::beginTransaction();

        try {

            if ((new FaqCreateService($faq, $request))->run()) {

                DB::commit();

                return $this->response($faq->refresh());
            }

            throw (new HttpException(ResponseCodes::BAD_REQUEST));

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }
}
