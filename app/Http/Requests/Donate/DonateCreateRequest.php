<?php

namespace App\Http\Requests\Donate;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class DonateCreateRequest
 * @package App\Http\Requests\Donate
 */
class DonateCreateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'startup_id'        => [
                'bail',
                'required',
                'integer',
                Rule::exists('startups', 'id'),
            ],
            'amount'            => [
                'bail',
                'required',
                'integer',
                'min:100',
                'max:99999',
            ],
            'payment_method_id' => [
                'required',
                'string',
            ]
        ];
    }
}
