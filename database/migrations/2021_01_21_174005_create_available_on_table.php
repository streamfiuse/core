<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableOnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_on', function (Blueprint $table) {
            $table->foreignId('content_id');
            $table->foreign('content_id')->references('id')->on('content');
            $table->foreignId('streaming_service_id');
            $table->foreign('streaming_service_id')->references('id')->on('streaming_services');
            $table->boolean('available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_on');
    }
}
