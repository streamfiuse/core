<?php


namespace App\Console\Commands\Monitoring\Fiuselist\Service;


use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class FiuselistDatabaseService
{
    public function freePossibleDislikedContents(): void
    {
        DB::table('content_users')
            ->where('free_date', '=', Date::now())
            ->where('like_status', '=', 'disliked')
            ->update([
                'like_status' => 'no_interaction',
                'free_date' => null
            ]);
    }
}
