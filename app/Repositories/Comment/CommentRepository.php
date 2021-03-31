<?php

namespace App\Repositories\Comment;

use App\Models\Comment\Comment;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class CommentRepository
 * @package App\Repositories\Comment
 */
class CommentRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $serches = [
        'owner_id' => '='
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'owner' => 'owner_id',
    ];

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Comment::class;
    }

    /**
     * @param Request      $request
     * @param Model|null   $model
     * @param Comment|null $comment
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filters(Request $request, Model $model = null, Comment $comment = null)
    {
        return parent::filters($request, $comment)->where('target_class', $model->getMorphClass());
    }
}
