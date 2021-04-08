<?php

namespace App\Models\StartupNews;

use App\Models\Comment\Comment;
use App\Models\Like\Like;
use App\Models\Startup\Startup;
use App\Models\StartupNews\Checker\StartupNewsChecker;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StartupNews
 * @property       $startup_id
 * @property       $is_publish
 * @property       $published_at
 * @property-read  $startup
 * @property-read  $texts
 * @property-read  $likes
 * @property-read  $comments
 * @package App\Models
 */
class StartupNews extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'startup_id',
        'is_publish',
        'published_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'published_at',
    ];

    protected $relations = [
        'startup'  => [
            'belongsTo',
            'startup_id'
        ],
        'texts'    => [
            'morphMany',
            'target_id',
        ],
        'likes'    => [
            'morphMany',
            'target_id',
        ],
        'comments' => [
            'morphMany',
            'target_id',
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class, 'startup_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function texts()
    {
        return $this->morphMany(Text::class, 'textable', 'target_class', 'target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable', 'target_class', 'target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable', 'target_class', 'target_id');
    }

    /**
     * @return StartupNewsChecker
     */
    public function getChecker()
    {
        return new StartupNewsChecker($this);
    }
}
