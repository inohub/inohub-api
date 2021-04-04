<?php

namespace App\Repositories\StartupNews;

use App\Models\StartupNews\StartupNews;
use App\Repositories\Base\BaseRepository;

/**
 * Class StartupNewsRepository
 * @package App\Repositories\StartupNews
 */
class StartupNewsRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $searches = [
        'startup_id' => '=',
        'created_at' => '=',
        'updated_at' => '=',
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'startup'  => 'startup_id',
        'texts'    => 'target_id',
        'likes'    => 'target_id',
        'comments' => 'target_id',
    ];

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return StartupNews::class;
    }
}
