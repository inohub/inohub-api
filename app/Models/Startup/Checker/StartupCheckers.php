<?php

namespace App\Models\Startup\Checker;

use App\Models\Startup\Startup;
use App\Models\User\User;

/**
 * Class StartupCheckers
 * @property Startup $startup
 * @package App\Models\Startup\Checker
 */
class StartupCheckers
{
    private Startup $startup;

    /**
     * StartupCheckers constructor.
     *
     * @param Startup $startup
     */
    public function __construct(Startup $startup)
    {
        $this->startup = $startup;
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function checkLike(User $user)
    {
        return $this->startup->likes()->where('owner_id', $user->id);
    }
}
