<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeQuestionAndExamQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson', function (Blueprint $table) {
            $table->string('type')->default('lesson')->comment('lesson | exam | levle2');
        });

        Schema::create('exam_question', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('question_id');
            $table->integer('times')->comment('the max times a user can do that');
            $table->string('status')->default('Active')->comment('Active and Inactive');
            $table->integer('part')->nullable();
            $table->timestamps();
        });



        Schema::create('exam_user_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('user_id');
            $table->integer('question_id');
            $table->integer('turn');
            $table->integer('score');
            $table->string('answer')->nullable();
            $table->string('status')->commnet('right :1 , false : 2');
            $table->integer('part')->nullable();
            $table->timestamp('submit_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::dropIfExists('exam_question');
        Schema::dropIfExists('exam_user_answer');
    }
}
