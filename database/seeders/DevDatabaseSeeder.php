<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Content and user plus relation seeding
        User::factory()->count(4)->create();
        Content::factory()->count(100)->create();

        // Test account seeding
        $isTesterAlreadySeeded = (bool) (DB::table('users')->where('email', '=', 'tester@email.com')->count());
        if (!$isTesterAlreadySeeded) {
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
}
