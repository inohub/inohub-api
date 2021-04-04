<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class LessonUpdateRequest
 * @package App\Http\Requests\Lesson
 */
class LessonUpdateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'description'     => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
            'texts'           => [
                'required',
                'array',
            ],
            'texts.*.title'   => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'texts.*.content' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
        ];
    }
}
