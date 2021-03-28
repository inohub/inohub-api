<?php

namespace Database\Factories\Startup;

use App\Models\Startup\Startup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * Class StartupFactory
 * @package Database\Factories\Startup
 */
class StartupFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Startup::class;

    /**
     * @return array|void
     */
    public function definition()
    {
        $isPublish = rand(0,1);

        return [
            'name' => $this->faker->company,
            'subtitle' => $this->faker->jobTitle,
            'donation_amount' => rand(1000, 99999),
            'is_publish' => $isPublish,
            'published_at' => $isPublish ? Carbon::now() : null,
        ];
    }
}
