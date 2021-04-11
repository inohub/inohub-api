<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Variant\VariantCreateRequest;
use App\Http\Requests\Test\Variant\VariantUpdateRequest;
use App\Models\Test\Variant;
use App\Repositories\Test\VariantRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Test\Variant\VariantCreateService;
use App\Services\Test\Variant\VariantUpdateService;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response($this->variantRepository->getParams());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->variantRepository->filters($request);

        return $this->response($builder->get());
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

            if ((new VariantCreateService($variant, $request))->run()) {

                DB::commit();

                return $this->response($variant->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param Variant $variant
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Variant $variant)
    {
        $builder = $this->variantRepository->findOne($request, $variant);

        return $this->response($builder->first());
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

            if ((new VariantUpdateService($variant, $request))->run()) {

                DB::commit();

                return $this->response($variant->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

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
        $variant->delete();

        return $this->response([]);
    }
}
