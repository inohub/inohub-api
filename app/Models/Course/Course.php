<?php

namespace App\Models\Course;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\BaseModel\BaseModel;
use App\Models\Lesson\Lesson;
use App\Models\User\User;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Course
 * @property string          $name
 * @property string          $description
 * @property boolean         $is_publish
 * @property                 $published_at
 * @property-read User       $owner
 * @property-read Collection $lessons
 * @package App\Models\Course
 */
class Course extends BaseModel implements OwnerInterface
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }
}
