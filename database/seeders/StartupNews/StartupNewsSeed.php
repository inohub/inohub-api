<?php

namespace Database\Seeders\StartupNews;

use App\Models\Startup\Startup;
use App\Models\StartupNews\StartupNews;
use Illuminate\Database\Seeder;

/**
 * Class StartupNewsSeed
 * @package Database\Seeders\StartupNews
 */
class StartupNewsSeed extends Seeder
{
    public function run()
    {
        Startup::all()->each(function (Startup $startup) {
            self::createStartupNews($startup, 1);
        });
    }

    /**
     * @param Startup $startup
     * @param         $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createStartupNews(Startup $startup, $num)
    {
        return StartupNews::factory($num)->make()->each(function (StartupNews $startupNews) use ($startup) {
            $startupNews->startup_id = $startup->id;
            $startupNews->save();
        });
    }
}
