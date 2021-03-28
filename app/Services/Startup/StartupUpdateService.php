<?php

namespace App\Services\Startup;

use App\Models\Startup\Startup;
use App\Services\Text\TextCreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

/**
 * Class StartupUpdateService
 * @property Startup $startup
 * @property Request $request
 * @package App\Services\Startup
 */
class StartupUpdateService
{
    private Startup $startup;
    private Request $request;

    /**
     * StartupUpdateService constructor.
     *
     * @param Startup $startup
     * @param Request $request
     */
    public function __construct(Startup $startup, Request $request)
    {
        $this->startup = $startup;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $data = $this->request->post();

        $this->startup->subtitle = Arr::get($data, 'subtitle');
        $this->startup->donation_amount = Arr::get($data, 'donation_amount');
        $this->startup->is_publish = Arr::get($data, 'is_publish', false);
        $this->startup->published_at = $this->startup->is_publish ? Carbon::now() : null;

        return $this->startup->save() && (new TextCreateService($this->startup, $this->request))->run();
    }
}
