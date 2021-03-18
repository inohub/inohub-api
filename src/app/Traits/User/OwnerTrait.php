<?php

namespace App\Traits\User;

use App\Components\Observers\OwnerObserver;
use App\Models\User\User;

trait OwnerTrait
{
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public static function bootOwnerTrait()
    {
        static::observe(OwnerObserver::class);
    }
}
