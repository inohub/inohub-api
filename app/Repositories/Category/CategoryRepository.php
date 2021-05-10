<?php


namespace App\Repositories\Category;

use App\Models\Category\Category;
use App\Repositories\Base\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories\Category
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Category::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'parent'   => [
                'belongsTo',
                'parent_id',
            ],
            'children' => [
                'hasMany',
                'parent_id',
            ]
        ];
    }
}
