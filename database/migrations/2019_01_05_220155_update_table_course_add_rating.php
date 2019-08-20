<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableCourseAddRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('course')) {
            Schema::table('course', function (Blueprint $table) {            
                $table->integer('rating_1')->nullable()->default(0);
                $table->integer('rating_2')->nullable()->default(0);
                $table->integer('rating_3')->nullable()->default(0);
                $table->integer('rating_4')->nullable()->default(0);
                $table->integer('rating_5')->nullable()->default(0);                                    
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
