<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Class CommentCreateRequest
 * @package App\Http\Requests\Comment
 */
class CommentCreateRequest extends BaseRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'text' => [
                'required',
                'string',
                'min:3',
                'max:500',
            ],
            'parent_id' => [
                'bail',
                'integer',
                Rule::exists('comments', 'id')->whereNull('parent_id'),
            ],
        ];
    }
}
