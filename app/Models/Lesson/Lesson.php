<?php

namespace App\Models\Lesson;

use App\Models\Course\Course;
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
 * @property-read $test
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

    protected $relations = [
        'course' => [
            'belongsTo',
            'course_id',
        ],
        'texts'  => [
            'morphMany',
            'target_id',
        ],
        'test'   => [
            'hasOne',
            'lesson_id',
        ],
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function test()
    {
        return $this->hasOne(Test::class, 'lesson_id');
    }
}
