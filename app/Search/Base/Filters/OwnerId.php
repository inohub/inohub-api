<?php

namespace App\Search\Base\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class OwnerId
 * @package App\Search\Startup\Filters
 */
class OwnerId
{
    /**
     * @param Builder $builder
     * @param         $value
     *
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('owner_id', $value);
    }
}
