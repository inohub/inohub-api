<?php

namespace App\Http\Controllers\Api\Course;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Models\Course\Course;
use App\Repositories\Course\CourseRepository;
use App\Services\Course\CourseCreateService;
use App\Services\Course\CourseUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class CourseController
 * @property CourseRepository $courseRepository
 * @package App\Http\Controllers\Api\Course
 */
class CourseController extends Controller
{
    private CourseRepository $courseRepository;

    /**
     * CourseController constructor.
     *
     * @param CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->courseRepository->doFilter($request);

        return $this->response($builder->get());
    }

    /**
     * @param CourseCreateRequest $request
     * @param Course              $course
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CourseCreateRequest $request, Course $course)
    {
        DB::beginTransaction();

        try {

            if ((new CourseCreateService($course, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($course->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Course $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Course $course)
    {
        return $this->response($course);
    }

    /**
     * @param CourseUpdateRequest $request
     * @param Course              $course
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        DB::beginTransaction();

        try {

            if ((new CourseUpdateService($course, new DataTransfer($request->post())))->run()) {

                DB::commit();

                return $this->response($course->refresh());
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Course $course
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return $this->response([]);
    }
}
