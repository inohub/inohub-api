<?php

namespace App\Http\Requests\UserTest;

use App\Http\Requests\Base\BaseRequest;
use App\Rules\UserTestResultAnswerRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Class UserTestResultCreateRequest
 * @package App\Http\Requests\UserTest
 */
class UserTestResultCreateRequest extends BaseRequest
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            'test_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('tests', 'id'),
                Rule::unique('user_test_results', 'test_id')
                    ->where('owner_id', Auth::id()),
            ],
            'answers' => [
                'required',
                'array',
                new UserTestResultAnswerRule($this->post('test_id')),
            ],
//            'answers.*.question_id' => [
//                'bail',
//                'required',
//                'integer',
//                Rule::exists('questions', 'id')
//                    ->where('test_id', $this->post('test_id')),
//            ],
//            'answers.*.variant_id' => [
//                'bail',
//                'integer',
//                'required_without:answers.*.answer_text',
//                Rule::exists('variants', 'id')
//                    ->where('question_id', ),
//            ],
//            'answers.*.answer_text' => [
//                'required_without:answers.*.variant_id',
//                'string',
//                'min:3',
//                'max:500',
//            ]
        ];
    }
}
