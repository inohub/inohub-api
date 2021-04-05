<?php

namespace App\Models\Startup\Checker;

use App\Models\Startup\Startup;
use App\Models\User\User;

/**
 * Class StartupChecker
 * @property Startup $startup
 * @package App\Models\Startup\Checker
 */
class StartupChecker
{
    private Startup $startup;

    /**
     * StartupChecker constructor.
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
