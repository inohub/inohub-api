<?php

namespace App\Http\Requests\Startup;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class StartupCreateRequest
 * @package App\Http\Requests\Startup
 */
class StartupCreateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'category_id'     => [
                'bail',
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
            'name'            => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
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
