<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionFlashCardMuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_flash_muti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('lesson_id')->nullable();   
            $table->integer('question_id')->nullable(); 
            $table->integer('parent_id')->nullable();                        
            $table->integer('status')->nullable();      
            $table->text('question')->nullable();                                    
            $table->text('explain_before')->nullable();
            $table->text('explain_after')->nullable();
            $table->text('img_before')->nullable();                                    
            $table->text('img_after')->nullable();                                    
            $table->integer('create_at')->nullable();
            $table->integer('update_at')->nullable();                     
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
