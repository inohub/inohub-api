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
            'subtitle'        => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'donation_amount' => [
                'required',
                'integer',
            ],
            'is_publish'      => [
                'boolean',
                'nullable',
            ],
            'texts'           => [
                'required',
                'array',
            ],
            'texts.*.title'   => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'text.*.content'  => [
                'required',
                'min:3',
                'max:500',
            ],
        ];
    }
}
