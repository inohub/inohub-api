<?php

namespace App\Services\Test\Question;

use App\Components\Request\DataTransfer;
use App\Models\Test\Question;

/**
 * Class QuestionCreateService
 * @property Question     $question
 * @property DataTransfer $request
 * @package App\Services\Test\Question
 */
class QuestionCreateService
{
    private Question $question;
    private DataTransfer $request;

    /**
     * QuestionCreateService constructor.
     *
     * @param Question     $question
     * @param DataTransfer $request
     */
    public function __construct(Question $question, DataTransfer $request)
    {
        $this->question = $question;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->question->test_id = $this->request->post('test_id');
        $this->question->text = $this->request->post('text');

        return $this->question->save();
    }
}
