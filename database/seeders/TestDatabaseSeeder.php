<?php

namespace Database\Seeders;

use Database\Seeders\Dev\ApiUserSeeder;
use Illuminate\Database\Seeder;

/**
 *
 *  DONT RUN IN PRODUCTION
 *
 */
class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            ApiUserSeeder::class
        );
    }
}