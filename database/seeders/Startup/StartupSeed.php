<?php

namespace Database\Seeders\Startup;

use App\Models\Startup\Startup;
use App\Models\User\User;
use Illuminate\Database\Seeder;

/**
 * Class StartupSeed
 * @package Database\Seeders\Startup
 */
class StartupSeed extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            self::createStartup($user, 1);
        });
    }

    /**
     * @param User $user
     * @param      $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createStartup(User $user, $num)
    {
        return Startup::factory($num)->make()->each(function (Startup $startup) use ($user) {
            $startup->owner_id = $user->id;
            $startup->save();
        });
    }
}
