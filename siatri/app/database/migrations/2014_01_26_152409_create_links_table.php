<?php

use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function($table) {
            $table->increments('id');
            $table->string('url');
            $table->boolean('parsed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }

}