<?php

use App\Models\CommentQuestion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('course_id')->nullable();
            $table->integer('question_id');
            $table->integer('lesson_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('content');
            $table->integer('status')->default(CommentQuestion::STATUS_ON);
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
        Schema::dropIfExists('question_comment');
    }
}
