<?php

namespace App\Interfaces\Owner;

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
