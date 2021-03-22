<?php

namespace App\Components\Paginate;

use Illuminate\Support\Collection;

class OffsetPaginator
{
    protected $total;
    protected $items;

    public function __construct($items, $total)
    {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);
        $this->total = $total;
    }

    public function total()
    {
        return $this->total;
    }

    public function items()
    {
        return $this->items;
    }
}
