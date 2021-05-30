<?php

namespace App\Http\Requests\Test\Answer;

use App\Http\Requests\Base\BaseRequest;
use App\Rules\QuestionIdExistsRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class AnswerCreateRequest
 * @package App\Http\Requests\Test\Answer
 */
class AnswerCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'question_id'  => [
                'bail',
                'required',
                'integer',
                new QuestionIdExistsRule(Auth::user()),
                Rule::unique('answers', 'question_id'),
                Rule::unique('variants', 'question_id'),
            ],
            'correct_text' => [
                'string',
                'min:3',
                'max:500',
            ]
        ];
    }
}
