<?php

namespace App\Http\Controllers\Api\Test;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Question\QuestionCreateRequest;
use App\Http\Requests\Test\Question\QuestionUpdateRequest;
use App\Models\Test\Question;
use App\Repositories\Test\QuestionRepository;
use App\Services\Test\Question\QuestionCreateService;
use App\Services\Test\Question\QuestionUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->questionRepository->doFilter($request);

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

            if ((new QuestionCreateService($question, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($question->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Question $question
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Question $question)
    {
        return $this->response($question);
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

            if ($question->test->lesson->course->isOwner(Auth::user()) &&
                (new QuestionUpdateService($question, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($question->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

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
        if ($question->test->lesson->course->isOwner(Auth::user())) {

            $question->delete();

            return $this->response([]);
        }

        throw new FailedResultException('Не удалось удалить');
    }
}
