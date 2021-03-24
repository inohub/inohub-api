<?php

namespace App\Repositories\Startup;

use App\Models\Startup\Startup;
use App\Repositories\Base\BaseRepository;

/**
 * Class StartupRepository
 * @package App\Repositories\Startup
 */
class StartupRepository extends BaseRepository
{
    protected $fields = [
        'id',
        'owner_id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $serches = [
        'owner_id'   => '=',
        'name'       => 'LIKE',
        'created_at' => '=',
        'updated_at' => '=',
    ];

    protected $relations = [
        'owner'    => 'owner_id',
    ];

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Startup::class;
    }
}
