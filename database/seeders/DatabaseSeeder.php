<?php

namespace Database\Seeders;

use Database\Seeders\Comment\CommentSeed;
use Database\Seeders\Course\CourseSeed;
use Database\Seeders\Donate\DonateSeed;
use Database\Seeders\Lesson\LessonSeed;
use Database\Seeders\Like\LikeSeed;
use Database\Seeders\Startup\StartupSeed;
use Database\Seeders\StartupNews\StartupNewsSeed;
use Database\Seeders\Text\TextSeed;
use Database\Seeders\User\UserSeed;
use Database\Seeders\Category\CategorySeed;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeed::class);
        $this->call(StartupSeed::class);
        $this->call(StartupNewsSeed::class);
        $this->call(LikeSeed::class);
        $this->call(CommentSeed::class);
        $this->call(CategorySeed::class);
        $this->call(DonateSeed::class);
        $this->call(CourseSeed::class);
        $this->call(LessonSeed::class);

        $this->call(TextSeed::class);
    }
}
