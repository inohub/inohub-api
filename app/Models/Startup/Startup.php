<?php

namespace App\Models\Startup;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Category\Category;
use App\Models\Faq\Faq;
use App\Models\Comment\Comment;
use App\Models\Donate\Donate;
use App\Models\Like\Like;
use App\Models\Startup\Checker\StartupChecker;
use App\Models\StartupNews\StartupNews;
use App\Models\Text\Text;
use App\Models\User\User;
use App\Observers\StartupObserver;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Startup
 * @property int             $owner_id
 * @property int             $category_id
 * @property string          $name
 * @property string          $subtitle
 * @property int             $donation_amount
 * @property int             $status
 * @property                 $status_changed
 * @property string          $block_reason
 * @property-read User       $owner
 * @property-read Category   $category
 * @property-read Collection $texts
 * @property-read Collection $likes
 * @property-read Collection $comments
 * @property-read Collection $startupNews
 * @property-read Collection $fags
 * @package App\Models\Startup
 */
class Startup extends Model implements OwnerInterface, HasMedia
{
    use HasFactory, OwnerTrait, ScopeOfOwner, InteractsWithMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'category_id',
        'name',
        'subtitle',
        'donation_amount',
        'status',
        'status_changed',
        'block_reason'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'status_changed',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function texts()
    {
        return $this->morphMany(Text::class, 'textable', 'target_class', 'target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'startup_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donates()
    {
        return $this->hasMany(Donate::class, 'startup_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function startupNews()
    {
        return $this->hasMany(StartupNews::class, 'startup_id');
    }

    /**
     * @return StartupChecker
     */
    public function getChecker()
    {
        return new StartupChecker($this);
    }

    /**
     * @return string
     */
    public function getPreviewImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('preview-image');
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeToApprove(Builder $query)
    {
        return $query->where('status', 2);
    }
}
