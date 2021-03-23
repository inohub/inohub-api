<?php

namespace App\Services\Startup;

use App\Models\Startup\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class StartupCreateService
 * @property Startup $startup
 * @property Request $request
 * @package App\Services\Startup
 */
class StartupCreateService
{
    private Startup $startup;
    private Request $request;

    /**
     * StartupCreateService constructor.
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

        $this->startup->name = Arr::get($data, 'name');
        $this->startup->description = Arr::get($data, 'description');

        return $this->startup->save();
    }
}
