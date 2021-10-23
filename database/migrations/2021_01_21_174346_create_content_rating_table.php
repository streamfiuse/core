<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_rating', function (Blueprint $table) {
            $table->foreignId('content_id');
            $table->foreign('content_id')->references('id')->on('content');
            $table->foreignId('rating_service_id');
            $table->foreign('rating_service_id')->references('id')->on('rating_services');
            $table->float('rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_rating');
    }
}
