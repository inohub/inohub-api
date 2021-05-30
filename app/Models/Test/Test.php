<?php

namespace App\Models\Test;

use App\Models\Lesson\Lesson;
use App\Models\UserTest\UserTestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Test
 * @property int             $lesson_id
 * @property string          $name
 * @property-read Lesson     $lesson
 * @property-read Collection $questions
 * @property-read Collection $userTestResults
 * @package App\Models\Test
 */
class Test extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'lesson_id',
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userTestResults()
    {
        return $this->hasMany(UserTestResult::class, 'test_id');
    }
}
