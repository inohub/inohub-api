<?php

namespace App\Services\Test\Answer;

use App\Models\Test\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class AnswerCreateService
 * @property Answer  $answer
 * @property Request $request
 * @package App\Services\Test\Answer
 */
class AnswerCreateService
{
    private Answer $answer;
    private Request $request;

    /**
     * AnswerCreateService constructor.
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

        $this->answer->fill([
            'question_id'  => Arr::get($data, 'question_id'),
            'correct_text' => Arr::get($data, 'correct_text'),
        ]);

        return $this->answer->save();
    }
}
