<?php

namespace Database\Seeders\Dev;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ApiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'apitester',
            'email' => 'apitester@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make(env('API_TESTER_PW')), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
