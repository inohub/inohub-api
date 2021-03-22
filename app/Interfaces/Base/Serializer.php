<?php

namespace App\Interfaces\Base;

/**
 * Interface Serializer
 * @package App\Interfaces\Base
 */
interface Serializer
{
    /**
     * @param $response
     *
     * @return mixed
     */
    public function serialize($response);

    /**
     * @return mixed
     */
    public function getHeaders();
}
