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
     * @return string
     */
    protected function getModelClass(): string
    {
        return StartupNews::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'startup'  => [
                'belongsTo',
                'startup_id'
            ],
            'texts'    => [
                'morphMany',
                'target_id',
            ],
            'likes'    => [
                'morphMany',
                'target_id',
            ],
            'comments' => [
                'morphMany',
                'target_id',
            ],
        ];
    }
}
