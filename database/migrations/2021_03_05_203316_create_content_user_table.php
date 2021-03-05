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
        Schema::create('content_user', function (Blueprint $table) {
            $table->integer('content_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->primary([
                'content_id',
                'user_id'
            ]);

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('content_id')
                ->references('id')->on('content')
                ->onDelete('cascade');

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
        Schema::dropIfExists('content_user');
    }
}
