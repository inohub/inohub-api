<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CanCreateTestInCourse implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return DB::table('lessons')
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where('lessons.id', $value)
            ->where('courses.is_publish', false)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
