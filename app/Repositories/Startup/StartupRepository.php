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
    protected $searches = [
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
        'owner'   => 'owner_id',
        'texts'   => 'target_id',
        'likes'   => 'target_id',
        'donates' => 'startup_id',
        'faqs' => 'startup_id'
    ];

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Startup::class;
    }
}
