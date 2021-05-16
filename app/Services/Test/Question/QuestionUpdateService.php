<?php

namespace App\Services\Test\Question;

use App\Components\Request\DataTransfer;
use App\Models\Test\Question;

/**
 * Class QuestionUpdateService
 * @property Question     $question
 * @property DataTransfer $request
 * @package App\Services\Test\Question
 */
class QuestionUpdateService
{
    private Question $question;
    private DataTransfer $request;

    /**
     * QuestionUpdateService constructor.
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
        $this->question->text = $this->request->post('text');

        return $this->question->save();
    }
}
