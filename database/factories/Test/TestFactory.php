<?php

namespace Database\Factories\Test;

use App\Models\Test\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TestFactory
 * @package Database\Factories\Test
 */
class TestFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Test::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(10),
        ];
    }
}
