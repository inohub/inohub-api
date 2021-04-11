<?php

namespace App\Http\Requests\Test\Question;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class QuestionUpdateRequest
 * @package App\Http\Requests\Test\Question
 */
class QuestionUpdateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'text' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ]
        ];
    }
}
