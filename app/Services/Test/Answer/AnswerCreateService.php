<?php

namespace App\Services\Test\Answer;

use App\Components\Request\DataTransfer;
use App\Models\Test\Answer;

/**
 * Class AnswerCreateService
 * @property Answer       $answer
 * @property DataTransfer $request
 * @package App\Services\Test\Answer
 */
class AnswerCreateService
{
    private Answer $answer;
    private DataTransfer $request;

    /**
     * AnswerCreateService constructor.
     *
     * @param Answer       $answer
     * @param DataTransfer $request
     */
    public function __construct(Answer $answer, DataTransfer $request)
    {
        $this->answer = $answer;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->answer->question_id = $this->request->post('question_id');
        $this->answer->correct_text = $this->request->post('correct_text');

        return $this->answer->save();
    }
}
