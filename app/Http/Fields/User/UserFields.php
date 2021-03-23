<?php

namespace App\Http\Fields\User;

/**
 * Class UserFields
 * @package App\Http\Fields\User
 */
class UserFields
{
    /**
     * @return string[]
     */
    public static function rules()
    {
        return [
            'id',
            'first_name',
            'last_name'
        ];
    }
}
