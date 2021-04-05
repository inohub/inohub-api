<?php

namespace Database\Seeders\Donate;

use App\Models\Donate\Donate;
use App\Models\Startup\Startup;
use App\Models\User\User;
use Illuminate\Database\Seeder;

/**
 * Class DonateSeed
 * @package Database\Seeders\Donate
 */
class DonateSeed extends Seeder
{
    public function run()
    {
        User::all()->each(function (User $user) {
            Startup::all()->each(function (Startup $startup) use ($user) {
                self::createDonate($user, $startup, 1);
            });
        });
    }

    /**
     * @param User    $user
     * @param Startup $startup
     * @param         $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createDonate(User $user, Startup $startup, $num)
    {
        return Donate::factory($num)->make()->each(function (Donate $donate) use ($user, $startup) {
            $donate->owner_id = $user->id;
            $donate->startup_id = $startup->id;

            $donate->save();
        });
    }
}
