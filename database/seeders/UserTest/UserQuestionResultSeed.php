<?php

namespace Database\Seeders\UserTest;

use App\Models\Test\Question;
use App\Models\Test\Test;
use App\Models\UserTest\UserQuestionResult;
use App\Models\UserTest\UserTestResult;
use Illuminate\Database\Seeder;

/**
 * Class UserQuestionResultSeed
 * @package Database\Seeders\UserTest
 */
class UserQuestionResultSeed extends Seeder
{
    public function run()
    {
        Test::all()->each(function (Test $test) {
            $test->userTestResults()->each(function (UserTestResult $userTestResult) use ($test) {
                $test->questions()->each(function (Question $question) use ($userTestResult) {
                    self::createUserQuestionResult($question, $userTestResult);
                });
            });
        });
    }

    /**
     * @param Question       $question
     * @param UserTestResult $userTestResult
     */
    public static function createUserQuestionResult(Question $question, UserTestResult $userTestResult)
    {
        UserQuestionResult::factory(1)->make()->each(function (UserQuestionResult $userQuestionResult) use ($question, $userTestResult) {
            $userQuestionResult->question_id = $question->id;
            $userQuestionResult->user_test_result_id = $userTestResult->id;
            if (is_null($question->answer)) {
                $variant = $question->variants[rand(0, count($question->variants)-1)];
                $userQuestionResult->variant_id = $variant->id;
                $userQuestionResult->is_correct = $variant->is_correct;
            } else {
                $userQuestionResult->answer_text = 'text from seed, hello';
            }

            $userQuestionResult->save();
        });
    }
}
