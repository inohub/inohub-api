<?php

namespace App\Http\Requests\Test\Variant;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class VariantCreateRequest
 * @package App\Http\Requests\Test\Variant
 */
class VariantCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'question_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('questions', 'id'),
                Rule::unique('answers', 'question_id'),
            ],
            'text'        => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
            'is_correct'  => [
                'boolean',
            ]
        ];
    }
}
