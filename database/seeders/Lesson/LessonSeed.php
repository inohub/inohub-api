<?php

namespace Database\Seeders\Lesson;

use App\Models\Course\Course;
use App\Models\Lesson\Lesson;
use Illuminate\Database\Seeder;

/**
 * Class LessonSeed
 * @package Database\Seeders\Lesson
 */
class LessonSeed extends Seeder
{
    public function run()
    {
        Course::all()->each(function (Course $course) {
            self::createLesson($course, 2);
        });
    }

    /**
     * @param Course $course
     * @param        $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createLesson(Course $course, $num)
    {
        return Lesson::factory($num)->make()->each(function (Lesson $lesson) use ($course) {
            $lesson->course_id = $course->id;

            $lesson->save();
        });
    }
}
