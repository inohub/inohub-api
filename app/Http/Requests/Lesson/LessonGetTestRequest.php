<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class LessonGetTestRequest
 * @package App\Http\Requests\Lesson
 */
class LessonGetTestRequest extends BaseRequest
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            'test_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('tests', 'id')
                    ->where('lesson_id', $this->lesson->id)
                    ->whereNull('deleted_at'),
            ]
        ];
    }
}
