<?php

namespace App\Http\Requests\Test\Test;

use App\Http\Requests\Base\BaseRequest;
use App\Rules\CanCreateTestInCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class TestCreateRequest
 * @package App\Http\Requests\Test
 */
class TestCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'lesson_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('lessons', 'id'),
                new CanCreateTestInCourse(Auth::user()),
            ],
            'name'      => [
                'required',
                'string',
                'min:3',
                'max:255',
            ]
        ];
    }
}
