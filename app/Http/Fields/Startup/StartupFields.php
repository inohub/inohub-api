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
            'owner_id',
            'name',
            'subtitle',
            'donation_amount',
            'is_publish',
            'published_at',
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
