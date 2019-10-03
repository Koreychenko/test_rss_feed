<?php

use \Migrations\Migration;

class CreateTokenTable extends Migration
{
    public function up()
    {
        $this->schema->create('token', function (Illuminate\Database\Schema\Blueprint $table) {
            // Auto-increment id
            $table->increments('id');
            $table->string('token',100)->unique();
            $table->integer('user_id');
            $table->dateTime('expire');
            // Required for Eloquent's created_at and updated_at columns
        });
    }

    public function down()
    {
        $this->schema->drop('token');
    }
}
