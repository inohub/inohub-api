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
    /**
     * @var string[]
     */
    protected $serches = [
        'owner_id'        => '=',
        'name'            => 'LIKE',
        'subtitle'        => 'LIKE',
        'donation_amount' => '=',
        'is_publish'      => '=',
        'published_at'    => '=',
        'created_at'      => '=',
        'updated_at'      => '=',
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'owner' => 'owner_id',
        'texts' => 'target_id',
    ];

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Startup::class;
    }
}
