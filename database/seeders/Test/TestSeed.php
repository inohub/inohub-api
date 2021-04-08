<?php

namespace Database\Seeders\Test;

use App\Models\Lesson\Lesson;
use App\Models\Test\Test;
use Illuminate\Database\Seeder;

/**
 * Class TestSeed
 * @package Database\Seeders\Test
 */
class TestSeed extends Seeder
{
    public function run()
    {
        Lesson::all()->each(function (Lesson $lesson) {
            self::createTest($lesson);
        });
    }

    /**
     * @param Lesson $lesson
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createTest(Lesson $lesson)
    {
        return Test::factory(1)->make()->each(function (Test $test) use ($lesson) {
            $test->lesson_id = $lesson->id;

            $test->save();
        });
    }
}
