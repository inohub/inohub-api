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
    public function getModelClass(): string
    {
        return Faq::class;
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
