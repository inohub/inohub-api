<?php

namespace App\Repositories\UserTest;

use App\Models\UserTest\UserTestResult;
use App\Repositories\Base\BaseRepository;

/**
 * Class UserTestResultRepository
 * @package App\Repositories\UserTest
 */
class UserTestResultRepository extends BaseRepository
{

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return UserTestResult::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'test'  => [
                'belongsTo',
                'test_id',
            ],
            'owner' => [
                'belongsTo',
                'owner_id',
            ]
        ];
    }
}
