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
        $users = User::all();
        foreach ($users as $user) {
            self::createStartup(1, $user);
        }
    }

    /**
     * @param      $num
     * @param User $user
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createStartup($num, User $user)
    {
        return Startup::factory($num)->make()->each(function (Startup $startup) use ($user) {
            $startup->owner_id = $user->id;
            $startup->save();
        });
    }
}
