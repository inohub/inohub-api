<?php

namespace App\Models\Comment;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Comment\Checker\CommentChecker;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @property      $id
 * @property      $owner_id
 * @property      $parent_id
 * @property      $text
 * @property      $target_class
 * @property      $target_id
 * @property-read $owner
 * @property-read $children
 * @property-read $parent
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

    protected $relations = [
        'parent' => [
            'belongsTo',
            'parent_id',
        ],
        'children' => [
            'hasMany',
            'parent_id',
        ],
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
