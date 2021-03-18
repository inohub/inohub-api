<?php

namespace App\Components\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseException extends HttpException
{
    private $data = [];

    private $validationErrors = [];

    private $debug = false;

    protected $result_code = false;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function setMessage($data)
    {
        $this->data['message'] = $data;

        return $this;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }

    public function setDebug(bool $debug)
    {
        $this->debug = $debug;

        return $this;
    }

    public function setValidationErrors(array $validationErrors)
    {
        $this->validationErrors = $validationErrors;
        return $this;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function geResultCode()
    {
        return $this->result_code;
    }
}
