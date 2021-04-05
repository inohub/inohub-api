<?php

namespace Database\Factories\Donate;

use App\Models\Donate\Donate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class DonateFactory
 * @package Database\Factories\Donate
 */
class DonateFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Donate::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => rand(1000, 9999),
        ];
    }
}
