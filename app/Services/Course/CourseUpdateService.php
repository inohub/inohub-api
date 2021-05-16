<?php

namespace App\Services\Course;

use App\Components\Request\DataTransfer;
use App\Models\Course\Course;
use Illuminate\Support\Carbon;

/**
 * Class CourseUpdateService
 * @property Course       $course
 * @property DataTransfer $request
 * @package App\Services\Course
 */
class CourseUpdateService
{
    private Course $course;
    private DataTransfer $request;

    /**
     * CourseUpdateService constructor.
     *
     * @param Course       $course
     * @param DataTransfer $request
     */
    public function __construct(Course $course, DataTransfer $request)
    {
        $this->course = $course;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->course->description = $this->request->post('description');
        $this->course->is_publish = $this->request->post('is_publish', false);
        $this->course->published_at = $this->course->is_publish ? Carbon::now() : null;

        return $this->course->save();
    }
}
