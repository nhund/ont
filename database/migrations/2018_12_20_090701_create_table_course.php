<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('course')) {
            Schema::create('course', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('avatar',255)->nullable();
                $table->integer('status')->nullable();            
                $table->integer('created_at')->nullable();
                $table->integer('updated_at')->nullable();
                $table->integer('user_id')->nullable();
                $table->integer('price')->nullable();
                $table->integer('study_time')->nullable();
                $table->integer('type')->nullable();                     
                $table->integer('discount')->nullable();                     
                $table->integer('category_id')->nullable();                     
                $table->integer('is_free')->nullable();                     
                $table->text('description')->nullable(); 
                $table->text('avatar_path')->nullable();                     
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
