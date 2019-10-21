<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamPartAndExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('minutes');
            $table->integer('parts')->default(1);
            $table->integer('repeat_time')->default(1);
            $table->integer('stop_time')->default(1);
            $table->double('total_score');
            $table->timestamp('start_time_at');
            $table->timestamp('end_time_at');
            $table->timestamps();
        });

        Schema::create('exam_part', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->string('name');
            $table->double('score');
            $table->integer('number_question');
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
        Schema::dropIfExists('exam');
        Schema::dropIfExists('exam_part');
    }
}
