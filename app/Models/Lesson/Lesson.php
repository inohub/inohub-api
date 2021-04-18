<?php

namespace App\Models\Lesson;

use App\Models\Course\Course;
use App\Models\Lesson\Checker\LessonChecker;
use App\Models\Test\Test;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lesson
 * @property      $course_id
 * @property      $name
 * @property      $description
 * @property-read $course
 * @property-read $texts
 * @property-read $tests
 * @package App\Models\Lesson
 */
class Lesson extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'course_id',
        'name',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function texts()
    {
        return $this->morphMany(Text::class, 'textable', 'target_class', 'target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests()
    {
        return $this->hasMany(Test::class, 'lesson_id');
    }

    /**
     * @return LessonChecker
     */
    public function getChecker()
    {
        return new LessonChecker($this);
    }
}
