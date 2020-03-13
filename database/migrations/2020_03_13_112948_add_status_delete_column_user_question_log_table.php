<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusDeleteColumnUserQuestionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_question_log', function (Blueprint $table) {
            $table->string('status_delete')->default(\App\Models\UserQuestionLog::ACTIVE);
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
            $table->dropColumn('status_delete');
        });
    }
}
