<?php

namespace App\Models\Startup;

use App\Interfaces\Base\OwnerInterface;
use App\Models\Base\BaseModel;
use App\Models\Text\Text;
use App\Models\User\User;
use App\Traits\Owner\OwnerTrait;
use App\Traits\Owner\ScopeOfOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 * @package App\Models\Startup
 */
class Startup extends BaseModel implements OwnerInterface
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
}
