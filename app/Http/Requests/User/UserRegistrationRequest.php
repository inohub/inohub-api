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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            "password" => 'required|string|min:6'
        ];
    }
}
