<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('question')) {
            Schema::create('question', function (Blueprint $table) {
                $table->increments('id');
                $table->mediumText('content')->nullable();
                $table->text('img_before')->nullable();
                $table->text('img_after')->nullable();   
                $table->integer('type')->nullable();
                $table->integer('parent_id')->nullable();
                $table->integer('lesson_id')->nullable(); 
                $table->integer('user_id')->nullable(); 
                $table->integer('created_at')->nullable(); 
                $table->integer('updated_at')->nullable(); 
                $table->text('explain_before')->nullable(); 
                $table->text('explain_after')->nullable(); 
                $table->text('question')->nullable(); 
                $table->text('question_after')->nullable();       
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
