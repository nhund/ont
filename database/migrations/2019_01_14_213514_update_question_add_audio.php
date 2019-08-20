<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionAddAudio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('question')) {
            Schema::table('question', function (Blueprint $table) {            
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
