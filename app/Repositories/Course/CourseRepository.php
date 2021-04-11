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
     * @return string[]
     */
    protected function getSearchFields(): array
    {
        return [
            'owner_id'     => '=',
            'name'         => 'LIKE',
            'is_publish'   => '=',
            'published_at' => '=',
            'created_at'   => '=',
            'updated_at'   => '='
        ];
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
        ];
    }
}
