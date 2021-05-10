<?php

namespace App\Repositories\Test;

use App\Models\Test\Question;
use App\Repositories\Base\BaseRepository;

/**
 * Class QuestionRepository
 * @package App\Repositories\Test
 */
class QuestionRepository extends BaseRepository
{

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Question::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'test'     => [
                'belongsTo',
                'test_id',
            ],
            'answer'   => [
                'hasOne',
                'question_id',
            ],
            'variants' => [
                'hasMany',
                'question_id',
            ]
        ];
    }
}
