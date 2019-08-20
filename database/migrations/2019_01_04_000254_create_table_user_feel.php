<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserFeel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_feel')) {
            Schema::create('user_feel', function (Blueprint $table) {
                $table->increments('id');
                $table->text('title')->nullable();
                $table->string('name',255)->nullable();
                $table->string('school',255)->nullable();    
                $table->text('avatar')->nullable();                                        
                $table->integer('create_date')->nullable();
                $table->integer('status')->nullable();                                                                
            });
        }
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
