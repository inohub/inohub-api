<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\Base\BaseRequest;

/**
 * Class CommentUpdateRequest
 * @package App\Http\Requests\Comment
 */
class CommentUpdateRequest extends BaseRequest
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
            ]
        ];
    }
}
