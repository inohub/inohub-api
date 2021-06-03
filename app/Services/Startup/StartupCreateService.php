<?php

namespace App\Services\Startup;

use App\Components\Request\DataTransfer;
use App\Models\Startup\Startup;
use App\Services\Text\TextsCreateService;
use Illuminate\Support\Carbon;

/**
 * Class StartupCreateService
 * @property Startup      $startup
 * @property DataTransfer $request
 * @package App\Services\Startup
 */
class StartupCreateService
{
    private Startup $startup;
    private DataTransfer $request;

    /**
     * StartupCreateService constructor.
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
        $this->startup->category_id = $this->request->post('category_id');
        $this->startup->name = $this->request->post('name');
        $this->startup->subtitle = $this->request->post('subtitle');
        $this->startup->donation_amount = $this->request->post('donation_amount');
        $this->startup->status = 2;

        return $this->startup->save() && (new TextsCreateService($this->startup, new DataTransfer([
                'texts' => $this->request->post('texts'),
            ])))->run();
    }
}
