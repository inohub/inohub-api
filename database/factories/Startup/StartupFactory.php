<?php

namespace Database\Factories\Startup;

use App\Models\Startup\Startup;
use App\StartupStatus\StartupStatus;
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
        return [
            'name'            => $this->faker->company,
            'subtitle'        => $this->faker->jobTitle,
            'donation_amount' => rand(1000, 99999),
            'status'          => StartupStatus::getList()[rand(0, 4)],
            'status_changed'  => Carbon::now()
        ];
    }
}
