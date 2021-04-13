<?php

namespace Database\Seeders\User;

use App\Models\User\User;
use App\Services\User\UserRegistrationService;
use Illuminate\Database\Seeder;

/**
 * Class UserSeed
 * @package Database\Seeders\User
 */
class UserSeed extends Seeder
{
    public function run()
    {
        self::createUser(10);
        self::createDeveloper();
    }

    /**
     * @param $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createUser($num)
    {
        return User::factory($num)->make()->each(function (User $user) {
            $user->save();


        });
    }

    public static function createDeveloper()
    {
        $user = User::all()->first();

        if (env('BASE_ADMIN_EMAIL') && env('BASE_ADMIN_PASSWORD')) {
            $user->email = env('BASE_ADMIN_EMAIL');
            $user->password = bcrypt(env('BASE_ADMIN_PASSWORD'));
            $user->save();
        }
    }
}
