<?php

namespace App\Http\Controllers\Api\Test;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Variant\VariantCreateRequest;
use App\Http\Requests\Test\Variant\VariantUpdateRequest;
use App\Models\Test\Variant;
use App\Repositories\Test\VariantRepository;
use App\Services\Test\Variant\VariantCreateService;
use App\Services\Test\Variant\VariantUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class VariantController
 * @property VariantRepository $variantRepository
 * @package App\Http\Controllers\Api\Test
 */
class VariantController extends Controller
{
    private VariantRepository $variantRepository;

    /**
     * VariantController constructor.
     *
     * @param VariantRepository $variantRepository
     */
    public function __construct(VariantRepository $variantRepository)
    {
        $this->variantRepository = $variantRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->variantRepository->doFilter($request);

        return $this->response($builder->customPaginate());
    }

    /**
     * @param VariantCreateRequest $request
     * @param Variant              $variant
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(VariantCreateRequest $request, Variant $variant)
    {
        DB::beginTransaction();

        try {

            if ((new VariantCreateService($variant, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($variant->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Variant $variant
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Variant $variant)
    {
        return $this->response($variant);
    }

    /**
     * @param VariantUpdateRequest $request
     * @param Variant              $variant
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(VariantUpdateRequest $request, Variant $variant)
    {
        DB::beginTransaction();

        try {

            if ($variant->question->test->lesson->course->isOwner(Auth::user()) &&
                (new VariantUpdateService($variant, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($variant->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Variant $variant
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Variant $variant)
    {
        if ($variant->question->test->lesson->course->isOwner(Auth::user())) {

            $variant->delete();

            return $this->response([]);
        }

        throw new FailedResultException('Не удалось удалить');
    }

    /**
     * @param Variant $variant
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function isCorrect(Variant $variant)
    {
        return $this->response($variant->is_correct);
    }
}
