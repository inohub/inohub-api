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
     * @param     $data
     * @param int $code
     *
     * @return JsonResponse
     */
    public function response($data, $code = 200)
    {
        return new JsonResponse([
            'result_code' => $code,
            'result_message' => ResponseCodes::getMessage()[$code],
            'data' => $data,
        ], $code);
    }
}
