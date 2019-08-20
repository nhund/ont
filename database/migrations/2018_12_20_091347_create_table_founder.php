<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFounder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('founder')) {
            Schema::create('founder', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title',255)->nullable();
                $table->string('name',255)->nullable();
                $table->text('img')->nullable();            
                $table->text('content')->nullable();
                $table->integer('status')->nullable();
                $table->integer('create_at')->nullable();
                
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
