<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRegistrationRequest;
use App\Models\User\User;
use App\ResponseCodes\ResponseCodes;
use App\Services\User\UserRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration', 'unauthorized']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->response(null,ResponseCodes::WRONG_DATA);
        }

        return $this->respondWithToken($token);
    }

    public function registration(UserRegistrationRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            if ((new UserRegistrationService($user, $request))->run()) {
                DB::commit();
                return $this->response($user->refresh(), ResponseCodes::CREATED);
            }

            return $this->response(null, ResponseCodes::FAILED_RESULT);
        } catch (\Exception $e) {
            return $this->response( $e->getMessage(), ResponseCodes::UNPROCESSABLE);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], ResponseCodes::SUCCESS);
    }

    public function unauthorized()
    {
        return $this->response(null,ResponseCodes::UNAUTHORIZED);
    }
}
