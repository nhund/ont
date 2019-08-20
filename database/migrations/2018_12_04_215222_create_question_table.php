<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('user_question_log', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id')->nullable();
        //     $table->integer('course_id')->nullable();
        //     $table->integer('lesson_id')->nullable();   
        //     $table->integer('question_id')->nullable();                        
        //     $table->integer('status')->nullable();                                    
        //     $table->integer('create_at')->nullable();                     
        // });
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
