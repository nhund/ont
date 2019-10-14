<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameWrongQuestionUserQuestionLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_question_log', function (Blueprint $table) {
            $table->renameColumn('wrong_number', 'total_turn');
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
            $table->renameColumn('total_turn', 'wrong_number');
        });
    }
}
