<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiProdUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
