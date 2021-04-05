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
     * @var string[]
     */
    public $searches = [
        'course_id'  => '=',
        'name'       => 'LIKE',
        'created_at' => '=',
        'updated_at' => '=',
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'course' => 'course_id',
        'texts' => 'target_id',
    ];

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Lesson::class;
    }
}
