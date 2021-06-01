<?php

namespace App\Services\Startup;

use App\Models\Startup\Startup;
use Illuminate\Support\Carbon;

/**
 * Class StartupPublishService
 * @property Startup $startup
 * @package App\Services\Startup
 */
class StartupPublishService
{
    private Startup $startup;

    /**
     * StartupPublishService constructor.
     *
     * @param Startup $startup
     */
    public function __construct(Startup $startup)
    {
        $this->startup = $startup;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->startup->is_publish = true;
        $this->startup->published_at = Carbon::now();

        return $this->startup->save();
    }
}
