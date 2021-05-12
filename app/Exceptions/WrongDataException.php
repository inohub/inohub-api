<?php

namespace App\Exceptions;

use App\ResponseCodes\ResponseCodes;
use App\Traits\Response\Response;
use Exception;

class WrongDataException extends Exception
{
    use Response;

    /**
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $this->response([], ResponseCodes::WRONG_DATA, $this->getMessage());
    }
}
