<?php

namespace App\Repositories\Startup;

use App\Models\Startup\Startup;
use App\Repositories\Base\BaseRepository;
use App\Search\Startup\StartupSearch;
use Illuminate\Http\Request;

/**
 * Class StartupRepository
 * @package App\Repositories\Startup
 */
class StartupRepository extends BaseRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Startup::class;
    }

    /**
     * @param Request $request
     *
     * @return StartupSearch
     */
    public function search(Request $request)
    {
        return new StartupSearch($request);
    }
}
