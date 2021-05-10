<?php

namespace App\Exceptions;

use App\ResponseCodes\ResponseCodes;
use App\Traits\Response\Response;
use Exception;

/**
 * Class NotFoundException
 * @package App\Exceptions
 */
class NotFoundException extends Exception
{
    use Response;

    /**
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->response([], ResponseCodes::NOT_FOUND, $this->getMessage());
    }
}
