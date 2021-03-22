<?php

namespace App\Search\Base\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Name
 * @package App\Search\Startup\Filters
 */
class Name
{
    /**
     * @param Builder $builder
     * @param         $value
     *
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('name', 'LIKE', '%' . $value . '%');
    }
}
