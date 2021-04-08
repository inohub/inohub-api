<?php

namespace Database\Factories\Test;

use App\Models\Test\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AnswerFactory
 * @package Database\Factories\Test
 */
class AnswerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Answer::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'correct_text' => $this->faker->text(10),
        ];
    }
}
