<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('feedback')) {
            Schema::create('feedback', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title',255)->nullable();
                $table->string('name',255)->nullable();
                $table->string('email',255)->nullable();    
                $table->text('content')->nullable();                        
                $table->integer('course_id')->nullable();
                $table->integer('question_id')->nullable();
                $table->integer('user_id')->nullable();   
                $table->integer('teacher_id')->nullable();   
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
