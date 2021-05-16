<?php

namespace App\Repositories\UserTest;

use App\Models\UserTest\UserQuestionResult;
use App\Repositories\Base\BaseRepository;

/**
 * Class UserQuestionResultRepository
 * @package App\Repositories\UserTest
 */
class UserQuestionResultRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return UserQuestionResult::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'question'       => [
                'belongsTo',
                'question_id',
            ],
            'userTestResult' => [
                'belongsTo',
                'user_test_result_id',
            ],
            'variant'        => [
                'belongsTo',
                'variant_id',
            ]
        ];
    }
}
