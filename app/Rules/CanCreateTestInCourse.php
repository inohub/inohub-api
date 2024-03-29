<?php

namespace App\Rules;

use App\Models\User\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

/**
 * Class CanCreateTestInCourse
 * @property User $user
 * @package App\Rules
 */
class CanCreateTestInCourse implements Rule
{
    private User $user;

    /**
     * CanCreateTestInCourse constructor.
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
        return DB::table('lessons')
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where('lessons.id', $value)
            ->where('courses.is_publish', false)
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
