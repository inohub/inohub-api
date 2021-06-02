<?php

namespace App\Http\Requests\Startup;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class StartupBlockRequest
 * @package App\Http\Requests\Startup
 */
class StartupBlockRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'block_reason' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ]
        ];
    }
}
