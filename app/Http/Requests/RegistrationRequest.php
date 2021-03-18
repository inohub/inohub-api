<?php

namespace App\Http\Requests;

use App\Http\ResponseCodes;
use App\Http\Traits\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class RegistrationRequest extends FormRequest
{
    use Response;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = $this->response('Validation error!', $validator->errors(), false, ResponseCodes::VALIDATION_ERROR);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users'
        ];
    }
}
