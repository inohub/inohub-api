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
     * @return string
     */
    protected function getModelClass(): string
    {
        return Comment::class;
    }

    /**
     * @return string[]
     */
    protected function getSearchFields(): array
    {
        return [
            'owner_id'   => '=',
            'parent_id'  => '=',
            'created_at' => '=',
            'updated_at' => '='
        ];
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'parent' => [
                'belongsTo',
                'parent_id',
            ],
            'children' => [
                'hasMany',
                'parent_id',
            ],
        ];
    }

    /**
     * @param Request    $request
     * @param Model|null $parentClass
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filters(Request $request, Model $parentClass = null)
    {
        return parent::filters($request)->where('target_class', $parentClass->getMorphClass());
    }

    /**
     * @param Request    $request
     * @param Model      $model
     * @param Model|null $parentClass
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findOne(Request $request, Model $model, Model $parentClass = null)
    {
        return parent::findOne($request, $model)->where('target_class', $parentClass->getMorphClass());
    }
}
