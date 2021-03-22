<?php

namespace App\Traits\Owner;

use App\Components\Observers\OwnerObserver;
use App\Models\User\User;

/**
 * Trait OwnerTrait
 * @package App\Traits\Owner
 */
trait OwnerTrait
{
    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public static function bootOwnerTrait()
    {
        static::observe(OwnerObserver::class);
    }
}
