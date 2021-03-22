<?php

namespace App\Search\Base\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Id
 * @package App\Search\Base\Filters
 */
class Id
{
    /**
     * @param Builder $builder
     * @param         $value
     *
     * @return mixed
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->ofId($value);
    }
}
