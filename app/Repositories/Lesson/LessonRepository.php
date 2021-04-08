<?php

namespace App\Repositories\Lesson;

use App\Models\Lesson\Lesson;
use App\Repositories\Base\BaseRepository;

/**
 * Class LessonRepository
 * @package App\Repositories\Lesson
 */
class LessonRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Lesson::class;
    }

    /**
     * @return string[]
     */
    public function getSearchFields(): array
    {
        return [
            'course_id'  => '=',
            'name'       => 'LIKE',
            'created_at' => '=',
            'updated_at' => '=',
        ];
    }
}
