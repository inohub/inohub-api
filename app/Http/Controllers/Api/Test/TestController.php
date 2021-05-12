<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Test\TestCreateRequest;
use App\Http\Requests\Test\Test\TestUpdateRequest;
use App\Models\Test\Test;
use App\Repositories\Test\TestRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Test\Test\TestCreateService;
use App\Services\Test\Test\TestUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class TestController
 * @property TestRepository $testRepository
 * @package App\Http\Controllers\Api\Test
 */
class TestController extends Controller
{
    private TestRepository $testRepository;

    /**
     * TestController constructor.
     *
     * @param TestRepository $testRepository
     */
    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->testRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param TestCreateRequest $request
     * @param Test              $test
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(TestCreateRequest $request, Test $test)
    {
        DB::beginTransaction();

        try {

            if ((new TestCreateService($test, $request))->run()) {

                DB::commit();

                return $this->response($test->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Test $test
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Test $test)
    {
        return $this->response($test);
    }

    /**
     * @param TestUpdateRequest $request
     * @param Test              $test
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(TestUpdateRequest $request, Test $test)
    {
        DB::beginTransaction();

        try {

            if ((new TestUpdateService($test, $request))->run()) {

                DB::commit();

                return $this->response($test->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Test $test
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return $this->response([]);
    }
}
