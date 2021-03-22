<?php

namespace App\Search\Startup;

use App\Models\Startup\Startup;
use App\Search\Base\BaseSearch;

/**
 * Class StartupSearch
 * @package App\Search\Startup
 */
class StartupSearch extends BaseSearch
{
    /**
     * @var string
     */
    protected $modelClass = Startup::class;

    /**
     * @var string[]
     */
    protected $sort = [
        'id',
        '-id',
        'created_at',
        '-created_at',
        'updated_at',
        '-updated_at',
    ];

    /**
     * @return string
     */
    protected function getNameSpace(): string
    {
        return __NAMESPACE__;
    }

    /**
     * @return array
     */
    protected function validationRules(): array
    {
        return parent::validationRules();
    }
}
