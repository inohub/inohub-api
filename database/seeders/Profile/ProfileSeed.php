<?php

namespace Database\Seeders\Profile;

use App\Models\Profile\Profile;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class ProfileSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            self::createProfile($user);
        });
    }

    public function createProfile($user)
    {
        return Profile::factory(1)->make()->each(function (Profile $profile) use ($user) {
            $profile->user_id = $user->id;
            $profile->save();
        });
    }
}
