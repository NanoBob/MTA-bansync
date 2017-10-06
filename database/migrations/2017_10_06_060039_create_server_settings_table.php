<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('server_id')->unsigned();
            $table->foreign('server_id')->references('id')->on('users')->onDelete('cascade');;

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('users');

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
        Schema::dropIfExists('server_settings');
    }
}
