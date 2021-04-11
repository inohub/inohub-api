<?php

namespace App\Http\Requests\Test\Test;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class TestUpdateRequest
 * @package App\Http\Requests\Test
 */
class TestUpdateRequest extends BaseRequest
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
        ];
    }
}
