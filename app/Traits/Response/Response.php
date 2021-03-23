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
     * @param null $data
     * @param int  $code
     *
     * @return JsonResponse
     */
    public function response($data = null, $code = ResponseCodes::SUCCESS)
    {
        return new JsonResponse([
            'code' => $code,
            'message' => ResponseCodes::getMessage()[$code],
            'data' => $data,
        ], $code);
    }
}
