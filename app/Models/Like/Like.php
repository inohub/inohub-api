<?php

namespace App\Models\Like;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Like\Checker\LikeChecker;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 * @property       $owner_id
 * @property       $target_class
 * @property       $target_id
 * @property-read  $owner
 * @package App\Models\Like
 */
class Like extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'target_class',
        'target_id',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'target_class',
        'target_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likeable()
    {
        return $this->morphTo(
            null,
            'target_class',
            'target_id',
            'id',
        );
    }

    /**
     * @return LikeChecker
     */
    public function getChecker()
    {
        return new LikeChecker($this);
    }
}
