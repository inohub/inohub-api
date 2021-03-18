<?php

namespace App\Components\Paginate;

use Illuminate\Support\Collection;

/**
 * Class OffsetPaginator
 * @package App\Components\Paginate
 */
class OffsetPaginator
{
    protected $total;
    protected $items;

    /**
     * OffsetPaginator constructor.
     *
     * @param $items
     * @param $total
     */
    public function __construct($items, $total)
    {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * @return Collection
     */
    public function items()
    {
        return $this->items;
    }
}
