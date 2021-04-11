<?php


namespace App\Repositories\Faq;

use App\Models\Faq\Faq;
use App\Repositories\Base\BaseRepository;

/**
 * Class FaqRepository
 * @package App\Repositories\Faq
 */
class FaqRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Faq::class;
    }

    /**
     * @return string[]
     */
    protected function getSearchFields(): array
    {
        return [
            'startup_id' => '=',
            'created_at' => '=',
            'updated_at' => '=',
        ];
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
            'text'    => [
                'morphOne',
                'target_class',
            ]
        ];
    }
}
