<?php

namespace App\Search\Base\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class NotId
 * @package App\Search\Base\Filters
 */
class NotId
{
    /**
     * @param Builder $builder
     * @param         $value
     *
     * @return mixed
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->ofNotId($value);
    }
}
