<?php
namespace App\Services\User;

use App\Http\Requests\User\UserRegistrationRequest;
use App\Models\User\User;
use Illuminate\Http\Request;

/**
 * Class UserRegistrationService
 * @property User $user
 * @package App\Services\User
 *
 */
class UserRegistrationService
{
    private User $user;

    private UserRegistrationRequest $request;

    public function __construct(User $user, UserRegistrationRequest $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function run()
    {
        $this->user->fill($this->request->validated());

        return $this->user->save();
    }
}
