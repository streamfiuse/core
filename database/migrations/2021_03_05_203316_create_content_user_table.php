<?php

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
        Schema::create('content_users', function (Blueprint $table) {
            $table->foreignId('content_id')->constrained('content');
            $table->foreignId('user_id')->constrained();

            $table->primary([
                'content_id',
                'user_id'
            ]);

            $table->integer('position')->unsigned();

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
        Schema::dropIfExists('content_users');
    }
}
