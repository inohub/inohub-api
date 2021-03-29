<?php

namespace App\Models\Startup;

use App\Interfaces\Owner\OwnerInterface;
use App\Models\Like\Like;
use App\Models\Startup\Checker\StartupCheckers;
use App\Models\Text\Text;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Startup
 * @property           $owner_id
 * @property           $name
 * @property           $subtitle
 * @property           $donation_amount
 * @property           $is_publish
 * @property           $published_at
 * @property-read      $owner
 * @property-read      $texts
 * @property-read      $likes
 * @package App\Models\Startup
 */
class Startup extends Model implements OwnerInterface
{
    use HasFactory, OwnerTrait, ScopeOfOwner;

    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'name',
        'subtitle',
        'donation_amount',
        'is_publish',
        'published_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'published_at',
    ];

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
     * @return StartupCheckers
     */
    public function getChecker()
    {
        return new StartupCheckers($this);
    }
}
