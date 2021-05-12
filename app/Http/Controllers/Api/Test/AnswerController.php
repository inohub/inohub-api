<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Answer\AnswerCreateRequest;
use App\Http\Requests\Test\Answer\AnswerUpdateRequest;
use App\Models\Test\Answer;
use App\Repositories\Test\AnswerRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Test\Answer\AnswerCreateService;
use App\Services\Test\Answer\AnswerUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class AnswerController
 * @property AnswerRepository $answerRepository
 * @package App\Http\Controllers\Api\Test
 */
class AnswerController extends Controller
{
    private AnswerRepository $answerRepository;

    /**
     * AnswerController constructor.
     *
     * @param AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->answerRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param AnswerCreateRequest $request
     * @param Answer              $answer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(AnswerCreateRequest $request, Answer $answer)
    {
        DB::beginTransaction();

        try {

            if ((new AnswerCreateService($answer, $request))->run()) {

                DB::commit();

                return $this->response($answer->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Answer $answer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Answer $answer)
    {
        return $this->response($answer);
    }

    /**
     * @param AnswerUpdateRequest $request
     * @param Answer              $answer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(AnswerUpdateRequest $request, Answer $answer)
    {
        DB::beginTransaction();

        try {

            if ((new AnswerUpdateService($answer, $request))->run()) {

                DB::commit();

                return $this->response($answer->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Answer $answer
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();

        return $this->response([]);
    }
}
