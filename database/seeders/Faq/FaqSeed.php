<?php

namespace Database\Seeders\Faq;

use App\Models\Startup\Startup;
use Illuminate\Database\Seeder;

class FaqSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startups = Startup::all();

        foreach ($startups as $startup) {
            foreach ([1,2,3] as $i) {
                $startup->faqs()
                    ->create([
                        'startup_id' => $startup->id
                    ]);
            }
        }
    }
}
