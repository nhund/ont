<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUserloglessonAddCheckLythuyet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user_lesson_log')) {
            Schema::table('user_lesson_log', function (Blueprint $table) {            
                $table->integer('pass_ly_thuyet')->nullable()->default(0);                                                                                                                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
