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
    public function getModelClass(): string
    {
        return Donate::class;
    }

    /**
     * @return string[]
     */
    public function getSearchFields(): array
    {
        return [
            'owner_id'   => '=',
            'startup_id' => '=',
            'created_at' => '=',
            'updated_at' => '=',
        ];
    }
}
