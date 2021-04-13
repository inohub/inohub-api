<?php

namespace Database\Seeders\UserTest;

use App\Models\Test\Test;
use App\Models\User\User;
use App\Models\UserTest\UserTestResult;
use Illuminate\Database\Seeder;

/**
 * Class UserTestResultSeed
 * @package Database\Seeders\UserTest
 */
class UserTestResultSeed extends Seeder
{
    public function run()
    {
        Test::all()->each(function (Test $test) {
            User::all()->each(function (User $user) use ($test) {
                self::createUserTestResult($user, $test);
            });
        });
    }

    /**
     * @param User $owner
     * @param Test $test
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createUserTestResult(User $owner, Test $test)
    {
        return UserTestResult::factory(1)->make()->each(function (UserTestResult $userTestResult) use ($owner, $test) {
            $userTestResult->owner_id = $owner->id;
            $userTestResult->test_id = $test->id;

            $userTestResult->save();
        });
    }
}
