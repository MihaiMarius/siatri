<?php

use Illuminate\Database\Migrations\Migration;

class CreateGameUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_user', function($table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('score')->unsigned();
            $table->boolean('isHost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_user');
    }

}