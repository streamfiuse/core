<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingServicesTable extends Migration
{
    const STR_LEN = 256;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', self::STR_LEN);
            $table->longText('rating_description');
            $table->integer('max_rating');
            $table->integer('min_rating');
            $table->float('step_size');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_services');
    }
}
