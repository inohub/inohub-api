<?php

namespace App\Http\Controllers\Api\Lesson;

use App\Components\Request\DataTransfer;
use App\Components\Test\TestShuffle;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\LessonCreateRequest;
use App\Http\Requests\Lesson\LessonGetTestRequest;
use App\Http\Requests\Lesson\LessonUpdateRequest;
use App\Models\Lesson\Lesson;
use App\Repositories\Lesson\LessonRepository;
use App\Services\Lesson\LessonCreateService;
use App\Services\Lesson\LessonUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return $this->response($builder->paginate());
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

            if ((new LessonCreateService($lesson, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($lesson->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

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

            if ($lesson->course->isOwner(Auth::user()) &&
                (new LessonUpdateService($lesson, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($lesson->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

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
        if ($lesson->course->isOwner(Auth::user())) {
            $lesson->delete();

            return $this->response([]);
        }

        throw new FailedResultException('Не удалось удалить');
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
