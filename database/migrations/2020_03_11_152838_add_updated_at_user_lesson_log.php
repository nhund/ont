<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtUserLessonLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_lesson_log', function (Blueprint $table) {$table->timestamps();});
        Schema::table('question_answer', function (Blueprint $table) {$table->timestamps();});
        Schema::table('question_bookmark', function (Blueprint $table) {$table->timestamps();});
        Schema::table('user_question_log', function (Blueprint $table) {$table->timestamps();});
        Schema::table('question_log_current', function (Blueprint $table) {$table->timestamps();});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_lesson_log', function (Blueprint $table) {$table->dropTimestamps();});
        Schema::table('question_answer', function (Blueprint $table) {$table->dropTimestamps();});
        Schema::table('question_bookmark', function (Blueprint $table) {$table->dropTimestamps();});
        Schema::table('user_question_log', function (Blueprint $table) {$table->dropTimestamps();});
        Schema::table('question_log_current', function (Blueprint $table) {$table->dropTimestamps();});
    }
}
