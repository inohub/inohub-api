<?php

namespace App\Models\Comment;

use App\Interfaces\Owner\OwnerInterface;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @property      $id
 * @property      $owner_id
 * @property      $text
 * @property      $target_class
 * @property      $target_id
 * @property-read $owner
 * @package App\Models\Comment
 */
class Comment extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'text',
        'target_class',
        'target_id',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'target_class',
        'target_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo(
            null,
            'target_class',
            'target_id',
            'id'
        );
    }
}
