<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_course')) {
            Schema::create('user_course', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();                        
                $table->integer('course_id')->nullable();                        
                $table->integer('status')->nullable(); 
                $table->integer('created_at')->nullable(); 
                $table->integer('updated_at')->nullable();                     
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
