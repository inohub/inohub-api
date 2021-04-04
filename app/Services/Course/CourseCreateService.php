<?php

namespace App\Services\Course;

use App\Models\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Class CourseCreateService
 * @property Course  $course
 * @property Request $request
 * @package App\Services\Course
 */
class CourseCreateService
{
    private Course $course;
    private Request $request;

    /**
     * CourseCreateService constructor.
     *
     * @param Course  $course
     * @param Request $request
     */
    public function __construct(Course $course, Request $request)
    {
        $this->course = $course;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->course->name = Arr::get($data, 'name');
        $this->course->description = Arr::get($data, 'description');
        $this->course->is_publish = Arr::get($data, 'is_publish', false);
        $this->course->published_at = $this->course->is_publish ? Carbon::now() : null;

        return $this->course->save();
    }
}
