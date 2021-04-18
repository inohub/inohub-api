<?php

namespace App\Http\Requests\Test\Question;

use App\Http\Requests\Base\BaseRequest;
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
                Rule::exists('tests', 'id')
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
