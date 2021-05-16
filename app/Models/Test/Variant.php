<?php

namespace App\Models\Test;

use App\Models\UserTest\UserQuestionResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Variant
 * @property      $question_id
 * @property      $text
 * @property      $is_correct
 * @property-read $question
 * @property-read $userQuestionResults
 * @package App\Models\Test
 */
class Variant extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userQuestionResults()
    {
        return $this->hasMany(UserQuestionResult::class, 'variant_id');
    }
}
