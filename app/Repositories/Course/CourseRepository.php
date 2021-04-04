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
     * @var string[]
     */
    public $searches = [
        'owner_id'     => '=',
        'name'         => 'LIKE',
        'is_publish'   => '=',
        'published_at' => '=',
        'created_at'   => '=',
        'updated_at'   => '='
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'owner' => 'owner_id',
    ];

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Course::class;
    }
}
