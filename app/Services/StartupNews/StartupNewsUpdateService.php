<?php

namespace App\Services\StartupNews;

use App\Components\Request\DataTransfer;
use App\Models\StartupNews\StartupNews;
use App\Services\Text\TextsCreateService;
use Illuminate\Support\Carbon;

/**
 * Class StartupNewsUpdateService
 * @property StartupNews  $startupNews
 * @property DataTransfer $request
 * @package App\Services\StartupNews
 */
class StartupNewsUpdateService
{
    private StartupNews $startupNews;
    private DataTransfer $request;

    /**
     * StartupNewsUpdateService constructor.
     *
     * @param StartupNews  $startupNews
     * @param DataTransfer $request
     */
    public function __construct(StartupNews $startupNews, DataTransfer $request)
    {
        $this->startupNews = $startupNews;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->startupNews->is_publish = $this->request->post('is_publish', false);
        $this->startupNews->published_at = $this->startupNews->is_publish ? Carbon::now() : null;

        return $this->startupNews->save() && (new TextsCreateService($this->startupNews, new DataTransfer([
                'texts' => $this->request->post('texts'),
            ])))->run();
    }
}
