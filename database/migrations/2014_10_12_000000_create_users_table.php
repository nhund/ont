<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('full_name')->unique();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->integer('birthday')->nullable();
            $table->integer('status')->nullable()->comment('1: active 2:block 0:deactive');
            $table->text('avatar')->nullable();
            $table->integer('level')->nullable()->comment('1:student 2:teacher 6:admin');
            $table->string('password');
            $table->integer('create_at')->nullable();
            $table->integer('update_at')->nullable();
            $table->text('note')->nullable();
            $table->rememberToken();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
