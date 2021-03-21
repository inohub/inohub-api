<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait Response {
    public function response($message, $data = null, $code = 200)
    {
        return new JsonResponse([
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $code);
    }
}
