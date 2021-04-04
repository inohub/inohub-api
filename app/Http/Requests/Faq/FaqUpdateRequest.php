<?php


namespace App\Http\Requests\Faq;


use App\Http\Requests\Base\BaseRequest;

class FaqUpdateRequest extends BaseRequest
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
            'content' => 'required|string|min:3|max:255'
        ];
    }
}
