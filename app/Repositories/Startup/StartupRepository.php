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
    protected function getModelClass(): string
    {
        return Startup::class;
    }

    /**
     * @return string[]
     */
    protected function getSearchFields(): array
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

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'texts'       => [
                'morphMany',
                'target_id',
            ],
            'faqs'        => [
                'hasMany',
                'startup_id',
            ],
            'likes'       => [
                'morphMany',
                'target_id',
            ],
            'comments'    => [
                'morphMany',
                'target_id',
            ],
            'donates'     => [
                'hasMany',
                'startup_id',
            ],
            'startupNews' => [
                'hasMany',
                'startup_id',
            ],
        ];
    }
}
