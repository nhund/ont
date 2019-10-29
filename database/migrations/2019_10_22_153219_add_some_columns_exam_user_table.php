<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsExamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('exam_user');

        Schema::create('exam_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('user_id');
            $table->integer('turn')->comment('the times a user done');
            $table->float('score')->comment('the score user got in the last time');
            $table->timestamp('last_at')->comment('them time last submit exam');
            $table->timestamp('begin_at')->nullable()->comment('the time begin exam');
            $table->integer('turn_stop')->default(0)->comment('the times had done exam');
            $table->integer('second_stop')->default(0);
            $table->timestamp('stopped_at')->nullable();
            $table->string('status')->default('Active');
            $table->float('highest_score')->default(0)->comment('the highest score user had got in exam');
            $table->string('status_stop')->default('Active');
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
        Schema::drop('exam_user');
    }
}
