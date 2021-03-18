<?php

namespace App\Traits\ScopeTraits;

use App\Components\Paginate\OffsetPaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopePaginate
 * @package App\Traits\ScopeTraits
 */
trait ScopePaginate
{
    /**
     * @param Builder $query
     * @param int     $perPage
     * @param null    $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopeCustomPaginate(Builder $query, $perPage = 20, $page = null)
    {
        $perPage = (int)request('per-page') ?: $perPage;

        return $query->paginate($perPage, '*', 'page', $page);
    }

    /**
     * @param Builder $query
     * @param int     $perPage
     * @param int     $offset
     *
     * @return OffsetPaginator
     */
    public function scopeOffsetPaginate(Builder $query, $perPage = 20, $offset = 0)
    {
        $perPage = (int)request('per-page') ?: $perPage;
        $offset = (int)request('offset') ?: $offset;
        $query->limit($perPage)->offset($offset);

        $total = $query->toBase()->getCountForPagination();

        $results = ($total)
            ? $query->get()
            : $query->getModel()->newCollection();

        return new OffsetPaginator($results, $total);
    }
}
