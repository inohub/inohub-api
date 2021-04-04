<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

class CategoryCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
            'parent_id'   => [
                'bail',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ];
    }
}
