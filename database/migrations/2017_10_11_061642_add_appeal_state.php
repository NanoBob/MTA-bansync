<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppealState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("appeal_states",function(Blueprint $table){
            $table->increments("id");
            $table->string("state");
        });

        Schema::table("ban_appeals",function(Blueprint $table){
            $table->integer("state_id")->unsigned()->after("server_id");
            $table->foreign("state_id")->references("id")->on("appeal_states");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("ban_appeals",function(Blueprint $table){
            $table->dropForeign("ban_appeals_state_id_foreign");
            $table->dropColumn("state_id");
        });
        Schema::dropIfExists("appeal_states");
    }
}
