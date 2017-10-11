<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppealBannedIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("ban_appeals",function(Blueprint $table){
            $table->integer("banned_id")->unsigned()->after("server_id");
            $table->foreign("banned_id")->references("id")->on("users");
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
            $table->dropForeign("ban_appeals_banned_id_foreign");
            $table->dropColumn("banned_id");
        });
    }
}
