<?php

namespace Database\Factories\Text;

use App\Models\Text\Text;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TextFactory
 * @package Database\Factories\Text
 */
class TextFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Text::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'title'    => $this->faker->jobTitle,
            'content' => $this->faker->text,
        ];
    }
}
