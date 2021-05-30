<?php

namespace App\Models\Test;

use App\Models\UserTest\UserQuestionResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Variant
 * @property int             $question_id
 * @property string          $text
 * @property boolean         $is_correct
 * @property-read Question   $question
 * @property-read Collection $userQuestionResults
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
