<?php

namespace App\Components\Logger;

use Monolog\Formatter\LineFormatter;

/**
 * Class CustomLogFormatter
 * @package App\Components\Logger
 */
class CustomLogFormatter extends LineFormatter
{
    /**
     * @param $value
     *
     * @return string
     */
    public function stringify($value): string
    {
        return $this->convertToString($value);
    }
}
