<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('setting_id')->unsigned();
            $table->foreign('setting_id')->references('id')->on('server_settings')->onDelete('cascade');;

            $table->integer('reason_id')->unsigned();
            $table->foreign('reason_id')->references('id')->on('ban_reasons');
            $table->longText('value');

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
        Schema::dropIfExists('setting_details');
    }
}
