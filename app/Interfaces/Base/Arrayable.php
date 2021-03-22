<?php

namespace App\Interfaces\Base;

/**
 * Interface Arrayable
 * @package App\Interfaces\Base
 */
interface Arrayable
{
    /**
     * @return mixed
     */
    public function fields();

    /**
     * @return mixed
     */
    public function extraFields();

    /**
     * @param array $fields
     * @param array $expand
     *
     * @return mixed
     */
    public function generateArray(array $fields = [], array $expand = []);
}
