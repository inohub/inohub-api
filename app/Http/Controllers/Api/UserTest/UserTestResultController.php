<?php

namespace App\Http\Controllers\Api\UserTest;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserTest\UserTestResultCreateRequest;
use App\Models\UserTest\UserTestResult;
use App\Repositories\UserTest\UserTestResultRepository;
use App\Services\UserTest\UserTestResult\UserTestResultCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTestResultController
 * @property UserTestResultRepository $userTestResultRepository
 * @package App\Http\Controllers\Api\UserTest
 */
class UserTestResultController extends Controller
{
    private UserTestResultRepository $userTestResultRepository;

    /**
     * UserTestResultController constructor.
     *
     * @param UserTestResultRepository $userTestResultRepository
     */
    public function __construct(UserTestResultRepository $userTestResultRepository)
    {
        $this->userTestResultRepository = $userTestResultRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->userTestResultRepository->doFilter($request);

        return $this->response($builder->paginate());
    }

    /**
     * @param UserTestResultCreateRequest $request
     * @param UserTestResult              $userTestResult
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(UserTestResultCreateRequest $request, UserTestResult $userTestResult)
    {
        DB::beginTransaction();

        try {

            if ((new UserTestResultCreateService($userTestResult, new DataTransfer($request->post())))->run()) {

                DB::commit();

                $userTestResult->refresh();
                $variantCount = $userTestResult->ofUserCorrectVariants()->count();
                $total = $userTestResult->test->questions()->count();

                return $this->response([
                    'correct' => $variantCount,
                    'total'    => $total,
                ]);
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param UserTestResult $userTestResult
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserTestResult $userTestResult)
    {
        return $this->response($userTestResult);
    }
}
