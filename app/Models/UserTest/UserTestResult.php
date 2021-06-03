<?php

namespace App\Models\UserTest;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\BaseModel\BaseModel;
use App\Models\Test\Test;
use App\Models\User\User;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserTestResult
 * @property int                     $owner_id
 * @property int                     $test_id
 * @property-read User               $owner
 * @property-read Test               $test
 * @property-read UserQuestionResult $userQuestionResult
 * @package App\Models\UserTest
 */
class UserTestResult extends BaseModel implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    protected $fillable = [
        'owner_id',
        'test_id',
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
    public function userQuestionResult()
    {
        return $this->hasOne(UserQuestionResult::class, 'user_test_result_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function scopeOfUserCorrectAnswers()
    {
        return $this->userQuestionResult()
            ->whereNull('variant_id')
            ->where('is_correct', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function scopeOfUserCorrectVariants()
    {
        return $this->userQuestionResult()
            ->whereNotNull('variant_id')
            ->where('is_correct', true);
    }
}
