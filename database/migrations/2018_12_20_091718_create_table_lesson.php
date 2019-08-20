<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('lesson')) {
            Schema::create('lesson', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',255)->nullable();
                $table->mediumText('description')->nullable();
                $table->integer('created_at')->nullable();            
                $table->integer('updated_at')->nullable();            
                $table->integer('parent_id')->nullable();
                $table->integer('course_id')->nullable();
                $table->integer('status')->nullable();
                $table->integer('lv1')->nullable();
                $table->integer('lv2')->nullable();
                $table->integer('is_exercise')->nullable()->default(0);
                $table->text('sapo')->nullable();
                $table->integer('repeat_time')->nullable();
                $table->integer('mode')->nullable();
                $table->text('avatar')->nullable();
                $table->text('audio')->nullable();
                $table->text('video')->nullable();
                
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
