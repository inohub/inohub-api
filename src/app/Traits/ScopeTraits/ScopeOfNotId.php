<?php

namespace App\Traits\ScopeTraits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeOfNotId
 * @package App\Traits\ScopeTraits
 */
trait ScopeOfNotId
{
    /**
     * @param Builder $query
     * @param         $id
     *
     * @return Builder
     */
    public function scopeOfNotId(Builder $query, $id)
    {
        if (is_array($id)) {
            return $query->whereNotIn($this->getTable().'.id', $id);
        }
        return $query->where($this->getTable().'.id', '!=',  $id);
    }
}
