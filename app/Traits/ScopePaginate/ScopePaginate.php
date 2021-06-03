<?php

namespace App\Traits\ScopePaginate;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopePaginate
 * @package PfdoPackages\LaravelComponents\Traits\ScopeTraits
 */
trait ScopePaginate
{
    /**
     * @param Builder $query
     * @param int     $perPage
     * @param null    $page
     *
     * @return array
     */
    public function scopeCustomPaginate(Builder $query, int $perPage = 20, $page = null)
    {
        $page = (int)request('page') ?: $page;

        return [
            'total' => $query->count(),
            'data'  => $query->skip($perPage * ($page - 1))->take($perPage)->get(),
        ];
    }
}
