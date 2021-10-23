<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    /**
     * Name of the associated Table in the Database
     *
     * @var string
     */
    protected $table = 'content';

    /**
     *
     * The primary key of the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     *
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'release_date',
        'content_type',
        'genre',
        'tags',
        'runtime',
        'short_description',
        'cast',
        'directors',
        'age_restriction',
        'poster_url',
        'youtube_trailer_url',
        'production_company',
        'seasons',
        'average_episode_count',
        'updated_at'
    ];

    protected $casts = [
        'varchar' => 'string',
        'release_date' => 'string',
        'content_type' => 'string',
        'genre' => 'string',
        'tags' => 'string',
        'runtime' => 'int',
        'short_description' => 'string',
        'cast' => 'string',
        'directors' => 'string',
        'age_restriction' => 'string',
        'seasons' => 'int',
        'average_episode_count' => 'int',
    ];
}
