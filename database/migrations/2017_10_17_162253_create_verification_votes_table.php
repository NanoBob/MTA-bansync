<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_votes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('verification_requests');

            $table->integer('voter_id')->unsigned();
            $table->foreign('voter_id')->references('id')->on('users');

            $table->boolean('vote');
            $table->longText('reason');

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
        Schema::dropIfExists('verification_votes');
    }
}
