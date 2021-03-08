<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        for ($i = 2; $i < 41; $i++) {
            DB::table('content_user')->where('content_id', '=',  $i)->update(['position' => $i%10 !== 0 ? $i%10 : 10]);
        }
    }
}
