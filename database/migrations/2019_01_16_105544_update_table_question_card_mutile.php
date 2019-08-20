<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableQuestionCardMutile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('question_flash_muti')) {
            Schema::table('question_flash_muti', function (Blueprint $table) {            
                $table->text('audio_content')->nullable();                                            
                $table->text('audio_explain_before')->nullable();                                            
                $table->text('audio_explain_after')->nullable();                                            
                $table->text('audio_question')->nullable();                                            
                $table->text('audio_question_after')->nullable();                                            
                                                        
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
