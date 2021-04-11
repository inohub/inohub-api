<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Question\QuestionCreateRequest;
use App\Http\Requests\Test\Question\QuestionUpdateRequest;
use App\Models\Test\Question;
use App\Repositories\Test\QuestionRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Test\Question\QuestionCreateService;
use App\Services\Test\Question\QuestionUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class QuestionController
 * @property QuestionRepository $questionRepository
 * @package App\Http\Controllers\Api\Test
 */
class QuestionController extends Controller
{
    private QuestionRepository $questionRepository;

    /**
     * QuestionController constructor.
     *
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response($this->questionRepository->getParams());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->questionRepository->filters($request);

        return $this->response($builder->get());
    }

    /**
     * @param QuestionCreateRequest $request
     * @param Question              $question
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(QuestionCreateRequest $request, Question $question)
    {
        DB::beginTransaction();

        try {

            if ((new QuestionCreateService($question, $request))->run()) {

                DB::commit();

                return $this->response($question->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request  $request
     * @param Question $question
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Question $question)
    {
        $builder = $this->questionRepository->findOne($request, $question);

        return $this->response($builder->first());
    }

    /**
     * @param QuestionUpdateRequest $request
     * @param Question              $question
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        DB::beginTransaction();

        try {

            if ((new QuestionUpdateService($question, $request))->run()) {

                DB::commit();

                return $this->response($question->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Question $question
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return $this->response([]);
    }
}