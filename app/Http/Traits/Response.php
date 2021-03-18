<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait Response {
    public function response($message, $data = null, $success = true, $code = 200)
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $code);
    }
}
