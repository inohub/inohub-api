<?php

namespace Database\Factories\Test;

use App\Models\Test\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class QuestionFactory
 * @package Database\Factories\Test
 */
class QuestionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Question::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(15),
        ];
    }
}
