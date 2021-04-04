<?php

namespace App\Http\Requests\Course;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class CourseCreateRequest
 * @package App\Http\Requests\Course
 */
class CourseCreateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'name'        => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
            'is_publish'  => [
                'boolean',
                'nullable',
            ],
        ];
    }
}
