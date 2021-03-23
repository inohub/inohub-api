<?php

namespace App\Http\Requests\Startup;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class StartupUpdateRequest
 * @package App\Http\Requests\Startup
 */
class StartupUpdateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:500'
            ],
        ];
    }
}
