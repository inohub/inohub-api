<?php


namespace App\Repositories\Category;


use App\Models\Startup\Startup;
use App\Repositories\Base\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $fields = [
        'id',
        'parent_id',
        'title',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $serches = [
        'parent_id'   => '=',
        'title'       => 'LIKE',
        'created_at' => '=',
        'updated_at' => '=',
    ];

    protected $relations = [
        'parent'    => 'parent_id',
    ];

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Startup::class;
    }
}
