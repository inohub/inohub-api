<?php

namespace App\Services\Startup;

use App\Components\Request\DataTransfer;
use App\Models\Startup\Startup;
use Illuminate\Support\Carbon;

/**
 * Class StartupChangeStatusService
 * @property Startup      $startup
 * @property DataTransfer $request
 * @package App\Services\Startup
 */
class StartupChangeStatusService
{
    private Startup $startup;
    private DataTransfer $request;

    /**
     * StartupChangeStatusService constructor.
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
        $this->startup->status = $this->request->post('status');
        $this->startup->status_changed = Carbon::now();

        if ($reason = $this->request->post('block_reason')) {
            $this->startup->block_reason = $reason;
        }

        return $this->startup->save();
    }
}
