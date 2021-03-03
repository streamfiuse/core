<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'tester',
            'email' => 'tester@email.com',
            'email_verified_at' => Date::now(),
            'password' => Hash::make('testerpassword'),
            'remember_token' => Str::random(12),
            'created_at' => Date::now()
        ]);
    }
}
