<?php

namespace Database\Factories\StartupNews;

use App\Models\StartupNews\StartupNews;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * Class StartupNewsFactory
 * @package Database\Factories\StartupNews
 */
class StartupNewsFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = StartupNews::class;

    /**
     * @return array
     */
    public function definition()
    {
        $isPublish = rand(0, 1);

        return [
            'is_publish' => $isPublish,
            'published_at' => $isPublish ? Carbon::now() : null
        ];
    }
}
