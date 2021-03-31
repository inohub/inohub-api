<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\Base\BaseRequest;

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
        ];
    }
}
