<?php

namespace App\Http\Requests\Course;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class CourseUpdateRequest
 * @package App\Http\Requests\Course
 */
class CourseUpdateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
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
