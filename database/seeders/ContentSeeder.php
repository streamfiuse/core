<?php

namespace Database\Seeders;

use App\Models\Content;
use Database\Factories\ContentFactory;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::factory()->count(2000)->create();
    }
}
