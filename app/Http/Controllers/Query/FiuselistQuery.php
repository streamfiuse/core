<?php


namespace App\Http\Controllers\Query;


use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class FiuselistQuery
{

    public function getFiuselistByUserId(int $userId): Builder
    {
        return DB::table('content_user')
            ->join('content', 'content.id', '=', 'content_user.content_id')
            ->where('user_id', '=', $userId)
            ->select(
                'content.id',
                'content.title',
                'content.release_date',
                'content.content_type',
                'content.genre',
                'content.tags',
                'content.runtime',
                'content.short_description',
                'content.cast',
                'content.directors',
                'content.age_restriction',
                'content.poster_url',
                'content.youtube_trailer_url',
                'content.production_company',
                'content.seasons',
                'content.average_episode_count',
                'content_user.like_status',
                'content_user.position'
            );
    }
}
