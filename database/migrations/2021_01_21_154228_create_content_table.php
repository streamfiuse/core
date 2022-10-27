<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTable extends Migration
{
    public const URL_LEN = 2083;
    public const STR_LEN = 256;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->id();
            $table->string('title', self::STR_LEN);
            $table->date('release_date');
            $table->enum('content_type', ['movie', 'tv_show', 'short_film', 'mini_tv_show']);
            $table->json('genre');
            $table->json('tags');
            $table->integer('runtime');
            $table->longText('short_description');
            $table->json('cast');
            $table->json('directors');
            $table->enum('age_restriction', [0, 6, 12, 16, 18]);
            $table->string('poster_url', self::URL_LEN);
            $table->string('youtube_trailer_url', self::URL_LEN);
            $table->string('production_company', self::STR_LEN);
            $table->integer('seasons');
            $table->integer('average_episode_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content');
    }
}
