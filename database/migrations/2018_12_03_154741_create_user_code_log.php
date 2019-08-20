<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCodeLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_code_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();                        
            $table->integer('code_id')->nullable();                        
            $table->string('code')->nullable(); 
            $table->integer('status')->nullable(); 
            $table->integer('create_at')->nullable();                     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
