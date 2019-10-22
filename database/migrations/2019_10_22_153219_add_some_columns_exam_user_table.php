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
        Schema::create('exam_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('user_id');
            $table->integer('turn')->comment('the times a user done');
            $table->integer('score')->comment('the score user got in the last time');;
            $table->timestamp('last_at');
            $table->timestamp('begin_at')->nullable();
            $table->integer('turn_stop')->default(0);
            $table->integer('second_stop')->default(0);
            $table->timestamp('stopped_at')->nullable();
            $table->string('status')->default('Active');
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
        Schema::dropIfExists('exam_user');
    }
}
