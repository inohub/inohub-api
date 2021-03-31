<?php

namespace Database\Seeders\Text;

use App\Models\Startup\Startup;
use App\Models\StartupNews\StartupNews;
use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Model;
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

        StartupNews::all()->each(function (StartupNews $startupNews) {
            self::createText($startupNews, 3);
        });
    }

    /**
     * @param Model $model
     * @param       $num
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|mixed
     */
    public static function createText(Model $model, $num)
    {
        return Text::factory($num)->make()->each(function (Text $text) use ($model) {
            $text->target_class = $model->getMorphClass();
            $text->target_id = $model->id;
            $text->save();
        });
    }
}
