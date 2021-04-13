<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class UserRegistrationRequest
 * @package App\Http\Requests\User
 */
class UserRegistrationRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            "password" => 'required|string|min:6'
        ];
    }
}
