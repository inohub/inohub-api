<?php

namespace App\Http\Controllers\Api\AdataDetail;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\ResponseCodes\ResponseCodes;
use App\Services\AdataDetail\AdataDetailCreateService;
use App\Services\AdataDetail\AdataDetailFetchDataService;
use Illuminate\Support\Facades\DB;

class AdataDetailsController extends Controller
{
    public function getFreshAdataToken(User $user)
    {
        DB::beginTransaction();

        try {
            if ((new AdataDetailCreateService($user))->run()) {
                DB::commit();

                return $this->response($user->refresh()->adataDetails()->get());
            }

            return $this->response([], ResponseCodes::FAILED_RESULT);
        } catch (\Throwable $exception) {
            return $this->response($exception->getMessage(), ResponseCodes::FAILED_RESULT);
        }
    }

    public function fetchAdataInfoByToken($token)
    {
        try {
            $data = (new AdataDetailFetchDataService($token))->run();

            return $this->response($data);
        } catch (\Throwable $exception) {
            return $this->response($exception->getMessage(), ResponseCodes::FAILED_RESULT);
        }
    }
}
