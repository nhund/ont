<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuestionLogCurrent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('question_log_current')) {
            Schema::create('question_log_current', function (Blueprint $table) {
                $table->increments('id');                       
                $table->integer('user_id')->nullable();
                $table->integer('course_id')->nullable();                
                $table->text('content')->nullable();
                $table->string('type',255)->nullable();
                $table->integer('create_date')->nullable();
                $table->integer('update_date')->nullable();                
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
