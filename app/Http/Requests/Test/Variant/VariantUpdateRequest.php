<?php

namespace App\Http\Requests\Test\Variant;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class VariantUpdateRequest
 * @package App\Http\Requests\Test\Variant
 */
class VariantUpdateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'text'       => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
            'is_correct' => [
                'boolean',
            ]
        ];
    }
}
