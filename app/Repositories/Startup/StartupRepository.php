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
     * @return string
     */
    public function getModelClass(): string
    {
        return Startup::class;
    }

    /**
     * @return string[]
     */
    public function getSearchFields(): array
    {
        return [
            'owner_id'        => '=',
            'name'            => 'LIKE',
            'subtitle'        => 'LIKE',
            'donation_amount' => '=',
            'is_publish'      => '=',
            'published_at'    => '=',
            'created_at'      => '=',
            'updated_at'      => '=',
        ];
    }
}
