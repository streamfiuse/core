<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_user', function (Blueprint $table) {
            $table->foreignId('content_id')->constrained('content');
            $table->foreignId('user_id')->constrained();

            $table->primary([
                'content_id',
                'user_id'
            ]);

            $table->integer('position')->unsigned()->nullable(true);
            $table->enum('like_status', ['liked', 'disliked', 'no_interaction'])->nullable(true);
            $table->integer('dislike_count')->default(0)->nullable(false);
            $table->date('free_date')->default(null)->nullable(true);

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
        Schema::dropIfExists('content_user');
    }
}
