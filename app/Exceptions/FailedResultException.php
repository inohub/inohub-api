<?php

namespace App\Exceptions;

use App\ResponseCodes\ResponseCodes;
use App\Traits\Response\Response;
use Exception;

/**
 * Class FailedResultException
 * @package App\Exceptions
 */
class FailedResultException extends Exception
{
    use Response;

    /**
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->response([], ResponseCodes::FAILED_RESULT, $this->getMessage());
    }
}
