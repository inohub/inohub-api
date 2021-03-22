<?php

namespace App\Interfaces\Base;

/**
 * Interface OwnerInterface
 * @package App\Interfaces\Base
 */
interface OwnerInterface
{
    /**
     * @return mixed
     */
    public function getOwnerId();

    /**
     * @return mixed
     */
    public function owner();
}
