<?php

namespace App\Search\Base\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Sort
 * @package App\Search\Base\Filters
 */
class Sort
{
    /**
     * @param Builder $builder
     * @param         $value
     *
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        if (substr($value, 0, 1) == '-') {
            $value = ltrim($value, '-');

            return $builder->orderBy($value, 'desc');
        }

        return $builder->orderBy($value);
    }
}
