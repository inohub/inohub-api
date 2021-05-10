<?php

namespace App\Traits\Response;

use App\ResponseCodes\ResponseCodes;
use Illuminate\Http\JsonResponse;

/**
 * Trait Response
 * @package App\Http\Traits
 */
trait Response
{
    /**
     * @param      $data
     * @param int  $code
     * @param null $message
     *
     * @return JsonResponse
     */
    public function response($data, $code = 200, $message = null)
    {
        return new JsonResponse([
            'result_code' => $code,
            'result_message' => is_null($message) ? ResponseCodes::getMessage()[$code] : $message,
            'data' => $data,
        ], $code);
    }
}
