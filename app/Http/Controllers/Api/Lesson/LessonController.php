<?php

namespace App\Http\Controllers\Api\Lesson;

use App\Components\Test\TestShuffle;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\LessonCreateRequest;
use App\Http\Requests\Lesson\LessonGetTestRequest;
use App\Http\Requests\Lesson\LessonUpdateRequest;
use App\Models\Lesson\Lesson;
use App\Repositories\Lesson\LessonRepository;
use App\ResponseCodes\ResponseCodes;
use App\Services\Lesson\LessonCreateService;
use App\Services\Lesson\LessonUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class LessonController
 * @property LessonRepository $lessonRepository
 * @package App\Http\Controllers\Api\Lesson
 */
class LessonController extends Controller
{
    private LessonRepository $lessonRepository;

    /**
     * LessonController constructor.
     *
     * @param LessonRepository $lessonRepository
     */
    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->lessonRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param LessonCreateRequest $request
     * @param Lesson              $lesson
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(LessonCreateRequest $request, Lesson $lesson)
    {
        DB::beginTransaction();

        try {

            if ((new LessonCreateService($lesson, $request))->run()) {

                DB::commit();

                return $this->response($lesson->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Lesson $lesson
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Lesson $lesson)
    {
        return $this->response($lesson);
    }

    /**
     * @param LessonUpdateRequest $request
     * @param Lesson              $lesson
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson)
    {
        DB::beginTransaction();

        try {

            if ((new LessonUpdateService($lesson, $request))->run()) {

                DB::commit();

                return $this->response($lesson->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Lesson $lesson
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return $this->response([]);
    }

    /**
     * @param LessonGetTestRequest $request
     * @param Lesson               $lesson
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTestForUser(LessonGetTestRequest $request, Lesson $lesson)
    {
        $test = (new TestShuffle($lesson, $request))->run();

        return $this->response($test);
    }
}
