<?php

namespace App\Repositories\Donate;

use App\Models\Donate\Donate;
use App\Repositories\Base\BaseRepository;

/**
 * Class DonateRepository
 * @package App\Repositories\Donate
 */
class DonateRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    public $searches = [
        'owner_id' => '=',
        'startup_id' => '=',
        'created_at' => '=',
        'updated_at' => '=',
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'owner' => 'owner_id',
        'startup' => 'startup_id',
    ];

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Donate::class;
    }
}
