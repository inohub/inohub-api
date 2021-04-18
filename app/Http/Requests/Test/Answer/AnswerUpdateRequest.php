<?php

namespace App\Http\Requests\Test\Answer;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class AnswerUpdateRequest
 * @package App\Http\Requests\Test\Answer
 */
class AnswerUpdateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'correct_text' => [
                'string',
                'min:3',
                'max:500',
            ],
        ];
    }
}
