<?php

use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entities');
    }

}