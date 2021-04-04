<?php


namespace App\Repositories\Faq;


use App\Models\Faq\Faq;
use App\Repositories\Base\BaseRepository;

class FaqRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $searches = [
        'startup_id' => '='
    ];

    /**
     * @var string[]
     */
    public $relations = [
        'startup' => 'startup_id',
        'text' => 'target_id'
    ];

    protected function getModelClass()
    {
        return Faq::class;
    }
}
