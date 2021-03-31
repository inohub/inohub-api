<?php

namespace App\Models\Donate\Checker;

use App\Models\Donate\Donate;
use App\Models\User\User;

/**
 * Class DonateChecker
 * @property Donate $donate
 * @package App\Models\Donate\Checker
 */
class DonateChecker
{
    private Donate $donate;

    /**
     * DonateChecker constructor.
     *
     * @param Donate $donate
     */
    public function __construct(Donate $donate)
    {
        $this->donate = $donate;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function idOwner(User $user)
    {
        return $this->donate->owner_id == $user->id;
    }
}
