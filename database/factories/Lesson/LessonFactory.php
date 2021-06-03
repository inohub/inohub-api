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
            'video_url' => $this->faker->randomElement([
                'https://www.youtube.com/embed/qSHP98i9mDU',
                'https://www.youtube.com/embed/tDKF2KrFDF0',
                'https://www.youtube.com/embed/a6xtQQqx1tg',
                'https://www.youtube.com/embed/0Be0fX9wbXc',
                'https://www.youtube.com/embed/vo4pMVb0R6M'
            ])
        ];
    }
}
