<?php

namespace App\Rules;

use App\Models\User\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

/**
 * Class QuestionIdExistsRule
 * @property User $user
 * @package App\Rules
 */
class QuestionIdExistsRule implements Rule
{
    private User $user;

    /**
     * QuestionIdExistsRule constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table('questions')
            ->join('tests', 'questions.test_id', '=', 'tests.id')
            ->join('lessons', 'tests.lesson_id', '=', 'lessons.id')
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where('questions.id', $value)
            ->where('courses.owner_id', $this->user->id)
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
