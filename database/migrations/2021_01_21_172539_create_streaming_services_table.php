<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamingServicesTable extends Migration
{
    const URL_LEN = 2083;
    const STR_LEN = 256;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streaming_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', self::STR_LEN);
            $table->string('website_url', self::URL_LEN);
            $table->string('logo_url', self::URL_LEN);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streaming_services');
    }
}
