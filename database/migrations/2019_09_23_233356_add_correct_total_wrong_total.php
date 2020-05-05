<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorrectTotalWrongTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_question_log', function (Blueprint $table) {
            $table->integer('correct_number');
            $table->integer('wrong_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_question_log', function (Blueprint $table) {
            $table->dropColumn('correct_number');
            $table->dropColumn('wrong_number');
        });
    }
}
