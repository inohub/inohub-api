<?php

namespace App\Repositories\Like;

use App\Models\Like\Like;
use App\Repositories\Base\BaseRepository;

/**
 * Class LikeRepository
 * @package App\Repositories\Like
 */
class LikeRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Like::class;
    }

    /**
     * @return array
     */
    protected function getRelations(): array
    {
        return [
            'owner' => [
                'belongsTo',
                'owner_id',
            ],
        ];
    }
}
