<?php

namespace Database\Seeders\Test;

use App\Models\Test\Question;
use App\Models\Test\Test;
use Illuminate\Database\Seeder;

/**
 * Class QuestionSeed
 * @package Database\Seeders\Test
 */
class QuestionSeed extends Seeder
{
    public function run()
    {
        Test::all()->each(function (Test $test) {
            self::createQuestion($test, 5);
        });
    }

    /**
     * @param Test $test
     * @param      $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createQuestion(Test $test, $num)
    {
        return Question::factory($num)->make()->each(function (Question $question) use ($test) {
            $question->test_id = $test->id;

            $question->save();
        });
    }
}
