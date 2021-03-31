<?php

namespace App\Http\Requests\StartupNews;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class StartupNewsCreateRequest
 * @package App\Http\Requests\StartupNews
 */
class StartupNewsCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'startup_id'      => [
                'bail',
                'required',
                'integer',
                Rule::exists('startups', 'id'),
                Rule::unique('startup_news', 'startup_id'),
            ],
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
