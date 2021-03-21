<?php


namespace App\Http\Requests\BaseRequest;


use App\Http\ResponseCodes;
use App\Http\Traits\Response;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    use Response;

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = $this->response($validator->errors(), false, ResponseCodes::VALIDATION_ERROR);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
