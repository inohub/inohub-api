<?php

namespace App\Components\Interfaces;

/**
 * Interface Arrayable
 * @package App\Components\Interfaces
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
