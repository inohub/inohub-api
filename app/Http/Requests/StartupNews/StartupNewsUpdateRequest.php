<?php

namespace App\Http\Requests\StartupNews;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class StartupNewsUpdateRequest
 * @package App\Http\Requests\StartupNews
 */
class StartupNewsUpdateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'is_publish'      => [
                'boolean',
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
            'texts.*.content' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
        ];
    }
}
