<?php

namespace Database\Factories\Startup;

use App\Models\Startup\Startup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class StartupFactory
 * @package Database\Factories\Startup
 */
class StartupFactory extends Factory
{
    protected $model = Startup::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->text(100),
        ];
    }
}
