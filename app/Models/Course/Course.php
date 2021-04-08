<?php

namespace App\Models\Course;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Lesson\Lesson;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 * @property      $name
 * @property      $description
 * @property      $is_publish
 * @property      $published_at
 * @property-read $owner
 * @property-read $lessons
 * @package App\Models\Course
 */
class Course extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'is_publish',
        'published_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'published_at',
    ];

    protected $relations = [
        'lessons' => [
            'hasMany',
            'course_id',
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }
}
