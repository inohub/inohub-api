<?php

namespace App\Services\UserTest\UserQuestionResult;

use App\Components\Request\DataTransfer;
use App\Models\UserTest\UserQuestionResult;

/**
 * Class UserQuestionResultCreateService
 * @property UserQuestionResult $userQuestionResult
 * @property DataTransfer       $request
 * @package App\Services\UserTest
 */
class UserQuestionResultCreateService
{
    private UserQuestionResult $userQuestionResult;
    private DataTransfer $request;

    /**
     * UserQuestionResultCreateService constructor.
     *
     * @param UserQuestionResult $userQuestionResult
     * @param DataTransfer       $request
     */
    public function __construct(UserQuestionResult $userQuestionResult, DataTransfer $request)
    {
        $this->userQuestionResult = $userQuestionResult;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->userQuestionResult->question_id = $this->request->post('question_id');
        $this->userQuestionResult->user_test_result_id = $this->request->post('user_test_result_id');
        $this->userQuestionResult->variant_id = $this->request->post('variant_id');
        $this->userQuestionResult->answer_text = $this->request->post('answer_text');

        if (!is_null($this->userQuestionResult->variant_id)) {
            $this->userQuestionResult->is_correct = $this->userQuestionResult->variant->is_correct;
        }

        return $this->userQuestionResult->save();
    }
}
