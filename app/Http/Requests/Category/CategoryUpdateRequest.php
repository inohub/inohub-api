<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\Base\BaseRequest;

class CategoryUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'parent_id' => 'nullable|exists:categories,id|integer'
        ];
    }
}
