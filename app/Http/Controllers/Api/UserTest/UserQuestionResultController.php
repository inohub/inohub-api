<?php

namespace App\Http\Controllers\Api\UserTest;

use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Models\UserTest\UserQuestionResult;
use App\Repositories\UserTest\UserQuestionResultRepository;
use App\Services\UserTest\UserQuestionResult\UserQuestionResultChangeCorrectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class UserQuestionResultController
 * @property UserQuestionResultRepository $userQuestionResultRepository
 * @package App\Http\Controllers\Api\UserTest
 */
class UserQuestionResultController extends Controller
{
    private UserQuestionResultRepository $userQuestionResultRepository;

    /**
     * UserQuestionResultController constructor.
     *
     * @param UserQuestionResultRepository $userQuestionResultRepository
     */
    public function __construct(UserQuestionResultRepository $userQuestionResultRepository)
    {
        $this->userQuestionResultRepository = $userQuestionResultRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->userQuestionResultRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param UserQuestionResult $userQuestionResult
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UserQuestionResult $userQuestionResult)
    {
        return $this->response($userQuestionResult);
    }

    /**
     * @param UserQuestionResult $userQuestionResult
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function changeCorrect(UserQuestionResult $userQuestionResult)
    {
        DB::beginTransaction();

        try {

            if ($userQuestionResult->question->test->lesson->course->isOwner(Auth::user()) &&
                (new UserQuestionResultChangeCorrectService($userQuestionResult))->run()) {

                DB::commit();

                return $this->response($userQuestionResult->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }
}
