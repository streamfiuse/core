<?php

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
        User::factory()->count(4)
            ->hasAttached(
                Content::factory()->count(10),
                [
                    'position' => 1,
                    'like_status' => 'liked',
                    'created_at' => Carbon::now()
                ]
            )
            ->create();

        DB::table('users')->insert([
            'name' => 'tester',
            'email' => 'tester@email.com',
            'email_verified_at' => Date::now(),
            'password' => Hash::make('testerpassword'),
            'remember_token' => Str::random(12),
            'created_at' => Date::now()
        ]);

        for ($i = 2; $i < 41; $i++) {
            DB::table('content_user')->where('content_id', '=',  $i)->update(['position' => $i%10 !== 0 ? $i%10 : 10]);
            DB::table('content_user')->where('content_id', '=',  $i)->update(['like_status' => $i%2 !== 0 ? 'liked' : 'disliked']);
        }
    }
}
