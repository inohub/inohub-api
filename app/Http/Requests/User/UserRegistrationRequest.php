<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

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
            'email'     => 'required|email|unique:users',
            "password"  => 'required|string|min:6',
            'role_slug' => [
                'bail',
                'required',
                'string',
                Rule::exists('roles', 'slug')
            ]
        ];
    }
}
