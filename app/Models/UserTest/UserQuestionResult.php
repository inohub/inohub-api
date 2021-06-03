<?php

namespace App\Models\UserTest;

use App\Models\BaseModel\BaseModel;
use App\Models\Test\Question;
use App\Models\Test\Variant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserQuestionResult
 * @property int                 $question_id
 * @property int                 $user_test_result_id
 * @property string              $answer_text
 * @property int                 $variant_id
 * @property boolean             $is_correct
 * @property-read Question       $question
 * @property-read UserTestResult $userTestResult
 * @property-read Variant        $variant
 * @package App\Models\UserTest
 */
class UserQuestionResult extends BaseModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'question_id',
        'user_test_result_id',
        'variant_id',
        'answer_text',
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
