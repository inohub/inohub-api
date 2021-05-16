<?php

namespace App\Services\UserTest\UserQuestionResult;

use App\Models\UserTest\UserQuestionResult;

/**
 * Class UserQuestionResultChangeCorrectService
 * @property UserQuestionResult $userQuestionResult
 * @package App\Services\UserTest\UserQuestionResult
 */
class UserQuestionResultChangeCorrectService
{
    private UserQuestionResult $userQuestionResult;

    /**
     * UserQuestionResultChangeCorrectService constructor.
     *
     * @param UserQuestionResult $userQuestionResult
     */
    public function __construct(UserQuestionResult $userQuestionResult)
    {
        $this->userQuestionResult = $userQuestionResult;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->userQuestionResult->is_correct = !$this->userQuestionResult->is_correct;

        return $this->userQuestionResult->save();
    }
}
