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
     * @return string
     */
    protected function getModelClass(): string
    {
        return Donate::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'startup' => [
                'belongsTo',
                'startup_id',
            ],
        ];
    }
}
