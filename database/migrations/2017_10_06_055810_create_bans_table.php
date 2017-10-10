<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->increments('id');


            $table->integer('banner_id')->unsigned();
            $table->foreign('banner_id')->references('id')->on('users');
            $table->integer('server_id')->unsigned();
            $table->foreign('server_id')->references('id')->on('users');
            $table->integer('ban_reason_id')->unsigned();
            $table->foreign('ban_reason_id')->references('id')->on('ban_reasons');
            $table->string('serial')->nullable();
            $table->string('ip')->nullable();
            $table->string('name')->nullable();
            $table->longText('details')->nullable();
            $table->dateTime('banned_until');
            $table->string('appeal_code');

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
        Schema::dropIfExists('bans');
    }
}
