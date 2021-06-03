<?php

namespace Database\Seeders\Adata;

use App\Models\AdataDetail\AdataDetail;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class AdataSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->adataDetails()->create([
                'token' => rand(1, 10),
                'checked_at' => now()
            ]);
        }
    }
}
