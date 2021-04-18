<?php

namespace App\Models\UserTest;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Test\Test;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserTestResult
 * @property      $owner_id
 * @property      $test_id
 * @property-read $owner
 * @property-read $test
 * @package App\Models\UserTest
 */
class UserTestResult extends Model implements OwnerInterface
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
}
