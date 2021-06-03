<?php

namespace App\Models\Comment;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\BaseModel\BaseModel;
use App\Models\Comment\Checker\CommentChecker;
use App\Models\User\User;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Comment
 * @property int             $owner_id
 * @property int             $parent_id
 * @property string          $text
 * @property string          $target_class
 * @property int             $target_id
 * @property-read User       $owner
 * @property-read Collection $children
 * @property-read Comment    $parent
 * @package App\Models\Comment
 */
class Comment extends BaseModel implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'parent_id',
        'text',
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
    public function commentable()
    {
        return $this->morphTo(
            null,
            'target_class',
            'target_id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * @return CommentChecker
     */
    public function getChecker()
    {
        return new CommentChecker($this);
    }
}
