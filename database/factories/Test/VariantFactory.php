<?php

namespace Database\Factories\Test;

use App\Models\Test\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class VariantFactory
 * @package Database\Factories\Test
 */
class VariantFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Variant::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(15),
            'is_correct' => rand(0, 1),
        ];
    }
}
