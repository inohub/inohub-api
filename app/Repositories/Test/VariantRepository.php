<?php

namespace App\Repositories\Test;

use App\Models\Test\Variant;
use App\Repositories\Base\BaseRepository;

/**
 * Class VariantRepository
 * @package App\Repositories\Test
 */
class VariantRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Variant::class;
    }

    /**
     * @return \string[][]
     */
    protected function getRelations(): array
    {
        return [
            'question'            => [
                'belongsTo',
                'question_id',
            ],
            'userQuestionResults' => [
                'hasMany',
                'variant_id',
            ]
        ];
    }
}
