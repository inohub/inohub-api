<?php

namespace App\Http\Requests\Faq;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class FaqCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3|max:255',
            'startup_id' => 'required|integer|exists:startups,id'
        ];
    }
}
