<?php

namespace App\Services\Test\Answer;

use App\Models\Test\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class AnswerUpdateService
 * @property Answer  $answer
 * @property Request $request
 * @package App\Services\Test\Answer
 */
class AnswerUpdateService
{
    private Answer $answer;
    private Request $request;

    /**
     * AnswerUpdateService constructor.
     *
     * @param Answer  $answer
     * @param Request $request
     */
    public function __construct(Answer $answer, Request $request)
    {
        $this->answer = $answer;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->answer->correct_text = Arr::get($data, 'correct_text');

        return $this->answer->save();
    }
}
