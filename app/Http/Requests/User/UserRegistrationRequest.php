<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest\BaseRequest;
use App\Http\Traits\Response;

class UserRegistrationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
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
