<?php

namespace App\Repositories\Course;

use App\Models\Course\Course;
use App\Repositories\Base\BaseRepository;

/**
 * Class CourseRepository
 * @package App\Repositories\Course
 */
class CourseRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Course::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'lessons' => [
                'hasMany',
                'course_id',
            ],
            'owner'   => [
                'belongsTo',
                'owner_id',
            ]
        ];
    }
}
