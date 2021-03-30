<?php

namespace App\Services\StartupNews;

use App\Models\StartupNews\StartupNews;
use App\Services\Text\TextCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Class StartupNewsUpdateService
 * @property StartupNews $startupNews
 * @property Request     $request
 * @package App\Services\StartupNews
 */
class StartupNewsUpdateService
{
    private StartupNews $startupNews;
    private Request $request;

    /**
     * StartupNewsUpdateService constructor.
     *
     * @param StartupNews $startupNews
     * @param Request     $request
     */
    public function __construct(StartupNews $startupNews, Request $request)
    {
        $this->startupNews = $startupNews;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->startupNews->is_publish = Arr::get($data, 'is_publish', false);
        $this->startupNews->published_at = $this->startupNews->is_publish ? Carbon::now() : null;

        return $this->startupNews->save() && (new TextCreateService($this->startupNews, $this->request))->run();
    }
}
