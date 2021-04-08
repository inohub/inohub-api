<?php


namespace App\Repositories\Category;


use App\Models\Category\Category;
use App\Repositories\Base\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Category::class;
    }

    public function getSearchFields(): array
    {
        return [
            'parent_id'  => '=',
            'title'      => 'LIKE',
            'created_at' => '=',
            'updated_at' => '=',
        ];
    }
}
