<?php

namespace App\Rules;

use App\Models\User\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

/**
 * Class TestIdExistsRule
 * @property User $user
 * @package App\Rules
 */
class TestIdExistsRule implements Rule
{
    private User $user;

    /**
     * TestIdExistsRule constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table('tests')
            ->join('lessons', 'tests.lesson_id', '=', 'lessons.id')
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where('tests.id', $value)
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
