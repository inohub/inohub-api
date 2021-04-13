<?php

namespace Database\Seeders\UserTest;

use Illuminate\Database\Seeder;

/**
 * Class UserTestSeed
 * @package Database\Seeders\UserTest
 */
class UserTestSeed extends Seeder
{
    public function run()
    {
        $this->call(UserTestResultSeed::class);
        $this->call(UserQuestionResultSeed::class);
    }
}
