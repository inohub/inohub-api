<?php

namespace App\Http\Controllers;

use App\Components\Request\DataTransfer;
use App\Exceptions\FailedResultException;
use App\Http\Requests\User\UserAttachRoleRequest;
use App\Http\Requests\User\UserRegistrationRequest;
use App\Models\User\User;
use App\ResponseCodes\ResponseCodes;
use App\Services\User\UserAttachRoleService;
use App\Services\User\UserRegistrationService;
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
            return $this->response([], ResponseCodes::WRONG_DATA);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param UserRegistrationRequest $request
     * @param User                    $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResultException
     */
    public function registration(UserRegistrationRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            if ((new UserRegistrationService($user, new DataTransfer($request->post())))->run()) {
                DB::commit();

                return $this->response($user->refresh(), ResponseCodes::CREATED);
            }

            throw new FailedResultException('Не удалось сохранить');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param UserAttachRoleRequest $request
     * @param User                  $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResultException
     * @throws \Throwable
     */
    public function attachRole(UserAttachRoleRequest $request, User $user)
    {
        DB::beginTransaction();

        try {

            if ((new UserAttachRoleService($user, $request->post('role_slug')))->run()) {

                DB::commit();

                return $this->response([]);
            }

            throw new FailedResultException('Не удалось сохранить');

        } catch (\Throwable $exception) {

            throw $exception;
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
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->response([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ], ResponseCodes::SUCCESS);
    }

    public function unauthorized()
    {
        return $this->response([], ResponseCodes::UNAUTHORIZED);
    }
}
