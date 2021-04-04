<?php

namespace Database\Factories\Course;

use App\Models\Course\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * Class CourseFactory
 * @package Database\Factories\Course
 */
class CourseFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Course::class;

    /**
     * @return array
     */
    public function definition()
    {
        $isPublish = rand(0, 1);

        return [
            'name'         => $this->faker->company,
            'description'  => $this->faker->text,
            'is_publish'   => $isPublish,
            'published_at' => $isPublish ? Carbon::now() : null,
        ];
    }
}
