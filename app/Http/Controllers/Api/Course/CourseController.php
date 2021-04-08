<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseCreateRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Models\Course\Course;
use App\Repositories\Course\CourseRepository;
use App\ResponseCodes\ResponseCodes;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParams()
    {
        return $this->response($this->courseRepository->getParams());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $builder = $this->courseRepository->filters($request);

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

            if ((new CourseCreateService($course, $request))->run()) {

                DB::commit();

                return $this->response($course->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

        } catch (\Throwable $exception) {

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param Course  $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Course $course)
    {
        $builder = $this->courseRepository->findOne($request, $course);

        return $this->response($builder->get());
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

            if ((new CourseUpdateService($course, $request))->run()) {

                DB::commit();

                return $this->response($course->refresh());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);

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
