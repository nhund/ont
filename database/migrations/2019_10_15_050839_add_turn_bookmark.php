<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTurnBookmark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_bookmark', function (Blueprint $table) {
            $table->integer('turn')->default(0)->comment('the times do that');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_bookmark', function (Blueprint $table) {
            $table->dropColumn('turn');
        });
    }
}
