<?php

namespace App\Services\Startup;

use App\Components\Request\DataTransfer;
use App\Models\Startup\Startup;
use App\Services\Text\TextsCreateService;
use Illuminate\Support\Carbon;

/**
 * Class StartupUpdateService
 * @property Startup      $startup
 * @property DataTransfer $request
 * @package App\Services\Startup
 */
class StartupUpdateService
{
    private Startup $startup;
    private DataTransfer $request;

    /**
     * StartupUpdateService constructor.
     *
     * @param Startup      $startup
     * @param DataTransfer $request
     */
    public function __construct(Startup $startup, DataTransfer $request)
    {
        $this->startup = $startup;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->startup->subtitle = $this->request->post('subtitle');
        $this->startup->donation_amount = $this->request->post('donation_amount');

        return $this->startup->save() && (new TextsCreateService($this->startup, new DataTransfer([
                'texts' => $this->request->post('texts'),
            ])))->run();
    }
}
