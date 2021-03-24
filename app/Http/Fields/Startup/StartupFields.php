<?php

namespace App\Http\Fields\Startup;

use App\Http\Fields\User\UserFields;

/**
 * Class StartupFields
 * @package App\Http\Fields\Startup
 */
class StartupFields
{
    /**
     * @return string[]
     */
    public static function fields()
    {
        return [
            'id',
            'name',
            'description',
        ];
    }

    /**
     * @return array
     */
    public static function relations()
    {
        return [
            'owner' => UserFields::rules(),
        ];
    }
}
