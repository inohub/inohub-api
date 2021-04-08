<?php

namespace Database\Seeders\Test;

use App\Models\Test\Answer;
use App\Models\Test\Question;
use App\Models\Test\Variant;
use Illuminate\Database\Seeder;

/**
 * Class QuestionContentSeed
 * @package Database\Seeders\Test
 */
class QuestionContentSeed extends Seeder
{
    public function run()
    {
        Question::all()->each(function (Question $question) {
            $rand = rand(0, 1);

            if ($rand) {
                self::createVariant($question, 4);
            } else {
                self::createAnswer($question);
            }
        });
    }

    /**
     * @param Question $question
     * @param          $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createVariant(Question $question, $num)
    {
        return Variant::factory($num)->make()->each(function (Variant $variant) use ($question) {
            $variant->question_id = $question->id;

            $variant->save();
        });
    }

    /**
     * @param Question $question
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createAnswer(Question $question)
    {
        return Answer::factory(1)->make()->each(function (Answer $answer) use ($question) {
            $answer->question_id = $question->id;

            $answer->save();
        });
    }
}
