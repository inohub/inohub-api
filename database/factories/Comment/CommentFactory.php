<?php

namespace Database\Factories\Comment;

use App\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CommentFactory
 * @package Database\Factories\Comment
 */
class CommentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Comment::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text,
        ];
    }
}
