<?php

namespace App\Services\Test\Question;

use App\Models\Test\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class QuestionUpdateService
 * @property Question $question
 * @property Request  $request
 * @package App\Services\Test\Question
 */
class QuestionUpdateService
{
    private Question $question;
    private Request $request;

    /**
     * QuestionUpdateService constructor.
     *
     * @param Question $question
     * @param Request  $request
     */
    public function __construct(Question $question, Request $request)
    {
        $this->question = $question;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->question->text = Arr::get($data, 'text');

        return $this->question->save();
    }
}
