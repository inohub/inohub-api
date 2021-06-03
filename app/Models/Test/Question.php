<?php

namespace App\Models\Test;

use App\Models\BaseModel\BaseModel;
use App\Models\UserTest\UserQuestionResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Question
 * @property int $test_id
 * @property string $text
 * @property-read Test $test
 * @property-read Answer $answer
 * @property-read Collection $variants
 * @property-read Collection $userQuestionResults
 * @package App\Models\Test
 */
class Question extends BaseModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'test_id',
        'text',
    ];

    protected $appends = [
        'content',
        'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function answer()
    {
        return $this->hasOne(Answer::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userQuestionResults()
    {
        return $this->hasMany(UserQuestionResult::class, 'question_id');
    }

    public function getTypeAttribute()
    {
        return $this->answer ? 'open' : 'multiple';
    }

    public function getContentAttribute()
    {
        return $this->getTypeAttribute() == 'open' ? $this->answer()->first() : $this->variants()->get();
    }
}
