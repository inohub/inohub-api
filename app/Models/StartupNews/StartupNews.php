<?php

namespace App\Models\StartupNews;

use App\Models\Comment\Comment;
use App\Models\Like\Like;
use App\Models\Startup\Startup;
use App\Models\StartupNews\Checker\StartupNewsChecker;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StartupNews
 * @property int              $startup_id
 * @property boolean          $is_publish
 * @property                  $published_at
 * @property-read Startup     $startup
 * @property-read Collection  $texts
 * @property-read Collection  $likes
 * @property-read Collection  $comments
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
