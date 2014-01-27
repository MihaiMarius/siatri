<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('oauth_provider', 10);
            $table->text('oauth_uid');
            $table->text('oauth_token');
            $table->text('oauth_secret');
            $table->text('username');
            $table->string('wampSession', 20)->nullable();
            $table->integer('total_score')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}