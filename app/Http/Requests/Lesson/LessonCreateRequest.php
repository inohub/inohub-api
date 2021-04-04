<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class LessonCreateRequest
 * @package App\Http\Requests\Lesson
 */
class LessonCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'course_id'       => [
                'bail',
                'required',
                'integer',
                Rule::exists('courses', 'id')
                    ->where('owner_id', Auth::id())
                    ->where('is_publish', false),
            ],
            'name'            => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
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
