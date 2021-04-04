<?php


namespace App\Repositories\Category;


use App\Models\Category\Category;
use App\Repositories\Base\BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $searches = [
        'parent_id'  => '=',
        'title'      => 'LIKE',
        'created_at' => '=',
        'updated_at' => '=',
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'parent'    => 'parent_id',
        'childrens' => 'parent_id'
    ];

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Category::class;
    }
}
