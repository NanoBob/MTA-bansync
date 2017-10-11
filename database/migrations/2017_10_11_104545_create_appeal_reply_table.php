<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeal_reply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("appeal_id")->unsigned();
            $table->foreign("appeal_id")->references("id")->on("ban_appeals");
            $table->integer("author_id")->unsigned();
            $table->foreign("author_id")->references("id")->on("users");
            $table->longText("content");
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
        Schema::dropIfExists('appeal_reply');
    }
}
