<?php
namespace App\Services\User;

use App\Http\Requests\User\UserRegistrationRequest;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $this->user->fill([
            'first_name' => $this->request->first_name,
            'last_name' => $this->request->last_name,
            'username' => $this->request->username,
            'email' => $this->request->email,
            'password' => Hash::make($this->request->password)
        ]);

        return $this->user->save();
    }
}
