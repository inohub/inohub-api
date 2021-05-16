<?php

namespace App\Services\UserTest\UserTestResult;

use App\Components\Request\DataTransfer;
use App\Models\UserTest\UserQuestionResult;
use App\Models\UserTest\UserTestResult;
use App\Services\UserTest\UserQuestionResult\UserQuestionResultCreateService;
use Illuminate\Support\Arr;

/**
 * Class UserTestResultCreateService
 * @property UserTestResult $userTestResult
 * @property DataTransfer   $request
 * @package App\Services\UserTest
 */
class UserTestResultCreateService
{
    private UserTestResult $userTestResult;
    private DataTransfer $request;

    /**
     * UserTestResultCreateService constructor.
     *
     * @param UserTestResult $userTestResult
     * @param DataTransfer   $request
     */
    public function __construct(UserTestResult $userTestResult, DataTransfer $request)
    {
        $this->userTestResult = $userTestResult;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->userTestResult->test_id = $this->request->post('test_id');

        $res = $this->userTestResult->save();

        foreach ($this->request->post('answers', []) as $value) {
            $res = $res && (new UserQuestionResultCreateService(new UserQuestionResult(), new DataTransfer([
                    'question_id'         => Arr::get($value, 'question_id'),
                    'user_test_result_id' => $this->userTestResult->id,
                    'variant_id'          => Arr::get($value, 'variant_id'),
                    'answer_text'         => Arr::get($value, 'answer_text'),
                ])))->run();
        }

        return $res;
    }
}
