<?php

namespace App\Services\User;

use App\Components\Request\DataTransfer;
use App\Models\User\User;

/**
 * Class UserRegistrationService
 * @property User         $user
 * @property DataTransfer $request
 * @package App\Services\User
 *
 */
class UserRegistrationService
{
    private User $user;
    private DataTransfer $request;

    /**
     * UserRegistrationService constructor.
     *
     * @param User         $user
     * @param DataTransfer $request
     */
    public function __construct(User $user, DataTransfer $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function run()
    {
        $this->user->email = $this->request->post('email');
        $this->user->password = bcrypt($this->request->post('password'));

        return $this->user->save();
    }
}
