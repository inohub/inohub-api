<?php

namespace Database\Seeders;

use Database\Seeders\Startup\StartupSeed;
use Database\Seeders\Text\TextSeed;
use Database\Seeders\User\UserSeed;
use Database\Seeders\Category\CategorySeed;
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
        $this->call(TextSeed::class);
        $this->call(CategorySeed::class);
    }
}
