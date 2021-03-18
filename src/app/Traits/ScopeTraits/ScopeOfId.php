<?php

namespace App\Traits\ScopeTraits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeOfId
 * @package App\Traits\ScopeTraits
 */
trait ScopeOfId
{
    /**
     * @param Builder $query
     * @param         $id
     *
     * @return Builder
     */
    public function scopeOfId(Builder $query, $id)
    {
        if (is_array($id)) {
            return $query->whereIn($this->getTable().'.id', $id);
        }
        return $query->where($this->getTable().'.id', '=',  $id);
    }
}
