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
    protected function getModelClass(): string
    {
        return Lesson::class;
    }

    /**
     * @return string[]
     */
    protected function getSearchFields(): array
    {
        return [
            'course_id'  => '=',
            'name'       => 'LIKE',
            'created_at' => '=',
            'updated_at' => '=',
        ];
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'course' => [
                'belongsTo',
                'course_id',
            ],
            'texts'  => [
                'morphMany',
                'target_id',
            ],
            'tests'  => [
                'hasMany',
                'lesson_id',
            ],
        ];
    }
}
