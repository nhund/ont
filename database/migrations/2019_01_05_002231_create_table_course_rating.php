<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCourseRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('course_rating')) {
            Schema::create('course_rating', function (Blueprint $table) {
                $table->increments('id');                       
                $table->integer('course_id')->nullable();
                $table->integer('rating_1')->default(0);
                $table->integer('rating_2')->default(0);
                $table->integer('rating_3')->default(0);
                $table->integer('rating_4')->default(0);
                $table->integer('rating_5')->default(0);                
                $table->integer('create_date')->nullable();
                $table->integer('update_date')->nullable();                                                                
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
