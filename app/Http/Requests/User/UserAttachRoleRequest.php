<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserAttachRoleRequest
 * @package App\Http\Requests\User
 */
class UserAttachRoleRequest extends BaseRequest
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            'role_slug' => [
                'bail',
                'required',
                'string',
                Rule::exists('roles', 'slug'),
            ]
        ];
    }
}
