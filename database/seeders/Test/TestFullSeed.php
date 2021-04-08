<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;

/**
 * Class TestFullSeed
 * @package Database\Seeders\Test
 */
class TestFullSeed extends Seeder
{
    public function run()
    {
        $this->call(TestSeed::class);
        $this->call(QuestionSeed::class);
        $this->call(QuestionContentSeed::class);
    }
}
