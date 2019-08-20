<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menu')) {
            Schema::create('menu', function (Blueprint $table) {
                $table->increments('id');                       
                $table->integer('parent_id')->nullable();
                $table->string('name',255)->nullable();
                $table->text('url')->nullable();
                $table->integer('menu_order')->default(0);
                $table->integer('create_date')->default(0);
                $table->integer('status')->default(0);                
                                                                             
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
