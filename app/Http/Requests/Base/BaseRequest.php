<?php


namespace App\Http\Requests\Base;

use App\ResponseCodes\ResponseCodes;
use App\Traits\Response\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Class BaseRequest
 * @package App\Http\Requests\Base
 */
class BaseRequest extends FormRequest
{
    use Response;

    /**
     * @param Validator $validator
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->response($validator->errors(), ResponseCodes::VALIDATION_ERROR);
        throw (new ValidationException($validator, $response));
    }
}
