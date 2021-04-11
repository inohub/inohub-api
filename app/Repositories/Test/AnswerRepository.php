<?php

namespace App\Repositories\Test;

use App\Models\Test\Answer;
use App\Repositories\Base\BaseRepository;

/**
 * Class AnswerRepository
 * @package App\Repositories\Test
 */
class AnswerRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Answer::class;
    }

    /**
     * @return string[]
     */
    protected function getSearchFields(): array
    {
        return [
            'question_id' => '=',
        ];
    }

    protected function getRelations(): array
    {
        return [
            'question' => [
                'belongsTo',
                'question_id',
            ]
        ];
    }
}
