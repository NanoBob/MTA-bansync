<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ban_appeals', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('ban_id')->unsigned();
            $table->foreign('ban_id')->references('id')->on('bans');
            $table->integer('banned_id')->unsigned();
            $table->foreign('banned_id')->references('id')->on('users');
            $table->longText('content');

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
        Schema::dropIfExists('ban_appeals');
    }
}
