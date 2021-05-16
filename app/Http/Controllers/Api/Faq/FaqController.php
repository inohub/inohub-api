<?php

namespace App\Http\Controllers\Api\Faq;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqCreateRequest;
use App\Http\Requests\Faq\FaqUpdateRequest;
use App\Models\Faq\Faq;
use App\Repositories\Faq\FaqRepository;
use App\Services\Faq\FaqCreateService;
use App\Services\Faq\FaqUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class FaqController
 * @property FaqRepository $faqRepository
 * @package App\Http\Controllers\Api\Faq
 */
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->faqRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param FaqCreateRequest $request
     * @param Faq              $faq
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(FaqCreateRequest $request, Faq $faq)
    {
        DB::beginTransaction();

        try {

            if ((new FaqCreateService($faq, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($faq->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Faq $faq
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Faq $faq)
    {
        return $this->response($faq);
    }

    /**
     * @param FaqUpdateRequest $request
     * @param Faq              $faq
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(FaqUpdateRequest $request, Faq $faq)
    {

        DB::beginTransaction();

        try {

            if ((new FaqUpdateService($faq, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($faq->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Faq $faq
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Faq $faq)
    {
        $faq->text->delete();
        $faq->delete();

        return $this->response([]);
    }
}
