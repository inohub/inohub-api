<?php

namespace App\Services\StartupNews;

use App\Models\StartupNews\StartupNews;
use App\Services\Text\TextsCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Class StartupNewsCreateService
 * @property StartupNews $startupNews
 * @property Request     $request
 * @package App\Services\StartupNews
 */
class StartupNewsCreateService
{
    private StartupNews $startupNews;
    private Request $request;

    /**
     * StartupNewsCreateService constructor.
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

        $this->startupNews->startup_id = Arr::get($data, 'startup_id');
        $this->startupNews->is_publish = Arr::get($data, 'is_publish', false);
        $this->startupNews->published_at = $this->startupNews->is_publish ? Carbon::now() : null;

        return $this->startupNews->save() && (new TextsCreateService($this->startupNews, $this->request))->run();
    }
}
