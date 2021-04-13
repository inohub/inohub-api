<?php

namespace App\Models\UserTest;

use App\Models\Test\Question;
use App\Models\Test\Variant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserQuestionResult
 * @property       $question_id
 * @property       $user_test_result_id
 * @property       $answer_text
 * @property       $variant_id
 * @property       $is_correct
 * @property-read  $question
 * @property-read  $userTestResult
 * @property-read  $variant
 * @package App\Models\UserTest
 */
class UserQuestionResult extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'user_test_result_id',
        'answer_text',
        'variant_id',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userTestResult()
    {
        return $this->belongsTo(UserTestResult::class, 'user_test_result_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
