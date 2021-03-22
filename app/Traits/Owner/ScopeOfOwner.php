<?php

namespace App\Traits\Owner;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Trait ScopeOfOwner
 * @package App\Traits\Owner
 */
trait ScopeOfOwner
{
    /**
     * @param Builder $query
     * @param null    $user_id
     *
     * @return Builder
     */
    public function scopeOfOwner(Builder $query, $user_id = null)
    {
        return $query->where($this->getTable().'.owner_id', '=',  $user_id ?: Auth::id());
    }
}
