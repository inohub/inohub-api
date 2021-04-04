<?php

namespace Database\Factories\Lesson;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class LessonFactory
 * @package Database\Factories\Lesson
 */
class LessonFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->colorName,
            'description' => $this->faker->text,
        ];
    }
}
