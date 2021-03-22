<?php

namespace App\Interfaces\Base;

/**
 * Interface ResponsePaginationInterface
 * @package App\Interfaces\Base
 */
interface ResponsePaginationInterface
{
    /**
     * @return mixed
     */
    public function total();

    /**
     * @return mixed
     */
    public function lastPage();

    /**
     * @return mixed
     */
    public function currentPage();

    /**
     * @return mixed
     */
    public function perPage();

    /**
     * @return mixed
     */
    public function items();
}
