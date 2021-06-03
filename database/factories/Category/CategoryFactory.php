<?php


namespace Database\Factories\Category;


use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * @return array|void
     */
    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(['Бизнес','Игры','Музыка','Технологии','ИТ','Фильмы','Искусство','Экология','Медицина','Образование']),
            'description' => $this->faker->jobTitle,
        ];
    }
}
