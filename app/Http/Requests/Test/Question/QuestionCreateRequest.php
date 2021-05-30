<?php

namespace App\Http\Requests\Test\Question;

use App\Http\Requests\Base\BaseRequest;
use App\Rules\TestIdExistsRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class QuestionCreateRequest
 * @package App\Http\Requests\Test\Question
 */
class QuestionCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'test_id' => [
                'bail',
                'required',
                'integer',
                new TestIdExistsRule(Auth::user()),
            ],
            'text'    => [
                'required',
                'string',
                'min:3',
                'max:500',
            ]
        ];
    }
}
