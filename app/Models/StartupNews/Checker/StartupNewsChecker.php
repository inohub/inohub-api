<?php

namespace App\Models\StartupNews\Checker;

use App\Models\StartupNews\StartupNews;
use App\Models\User\User;

/**
 * Class StartupNewsChecker
 * @property StartupNews $startupNews
 * @package App\Models\StartupNews\Checker
 */
class StartupNewsChecker
{
    private StartupNews $startupNews;

    /**
     * StartupNewsChecker constructor.
     *
     * @param StartupNews $startupNews
     */
    public function __construct(StartupNews $startupNews)
    {
        $this->startupNews = $startupNews;
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function checkLike(User $user)
    {
        return $this->startupNews->likes()->where('owner_id', $user->id);
    }
}
