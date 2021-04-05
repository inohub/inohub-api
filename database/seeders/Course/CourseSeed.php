<?php

namespace Database\Seeders\Course;

use App\Models\Course\Course;
use App\Models\User\User;
use Illuminate\Database\Seeder;

/**
 * Class CourseSeed
 * @package Database\Seeders\Course
 */
class CourseSeed extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            self::createCourse($user, 2);
        });
    }

    /**
     * @param User $user
     * @param      $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createCourse(User $user, $num)
    {
        return Course::factory($num)->make()->each(function (Course $course) use ($user) {
            $course->owner_id = $user->id;

            $course->save();
        });
    }
}
