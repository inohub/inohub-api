<?php

namespace Database\Seeders\Text;

use App\Models\Startup\Startup;
use App\Models\Text\Text;
use Illuminate\Database\Seeder;

/**
 * Class TextSeed
 * @package Database\Seeders\Text
 */
class TextSeed extends Seeder
{
    public function run()
    {
        Startup::all()->each(function (Startup $startup) {
            self::createText($startup, 3);
        });
    }

    /**
     * @param Startup $startup
     * @param         $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public static function createText(Startup $startup, $num)
    {
        return Text::factory($num)->make()->each(function (Text $text) use ($startup) {
            $text->target_class = $startup->getMorphClass();
            $text->target_id = $startup->id;
            $text->save();
        });
    }
}
