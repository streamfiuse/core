<?php

namespace Database\Seeders\Dev;

use App\Models\User;
use Illuminate\Database\Seeder;


class ApiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();
    }
}
