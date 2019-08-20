<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeacherSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('teacher_support')) {
            Schema::create('teacher_support', function (Blueprint $table) {
                $table->increments('id');                       
                $table->integer('user_id')->nullable();
                $table->integer('course_id')->nullable();
                $table->integer('status')->nullable();                                
                $table->integer('create_date')->nullable();                
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
