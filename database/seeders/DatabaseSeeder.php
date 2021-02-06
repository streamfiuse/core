<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'apiuser',
            'email' => 'apiuser@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$8KDbZks3XqWTsR0Fbo31E.f.mgJgEF/94e7/uUHQw7SAGugR1lA/q', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
