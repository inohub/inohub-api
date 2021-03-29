<?php

namespace Database\Seeders;

use Database\Seeders\Like\LikeSeed;
use Database\Seeders\Startup\StartupSeed;
use Database\Seeders\StartupNews\StartupNewsSeed;
use Database\Seeders\Text\TextSeed;
use Database\Seeders\User\UserSeed;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeed::class);
        $this->call(StartupSeed::class);
        $this->call(StartupNewsSeed::class);
        $this->call(TextSeed::class);
        $this->call(LikeSeed::class);
    }
}
