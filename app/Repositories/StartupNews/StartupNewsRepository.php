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
    public function getModelClass(): string
    {
        return StartupNews::class;
    }

    /**
     * @return string[]
     */
    public function getSearchFields(): array
    {
        return [
            'startup_id' => '=',
            'created_at' => '=',
            'updated_at' => '=',
        ];
    }
}
