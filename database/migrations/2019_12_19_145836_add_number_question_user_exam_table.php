<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumberQuestionUserExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_user', function (Blueprint $table) {
            $table->integer('until_number')->default(1);
            $table->integer('time')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_user', function (Blueprint $table) {
            $table->dropColumn('until_number');
            $table->dropColumn('time');
        });
    }
}
