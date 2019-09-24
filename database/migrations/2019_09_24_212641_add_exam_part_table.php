<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExamPartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_part', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('part_1')->nullable();
            $table->integer('part_2')->nullable();
            $table->integer('part_3')->nullable();
            $table->integer('part_4')->nullable();
            $table->integer('part_5')->nullable();
            $table->integer('part_6')->nullable();
            $table->integer('part_7')->nullable();
            $table->integer('part_8')->nullable();
            $table->integer('part_9')->nullable();
            $table->integer('part_10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_part');
    }
}
