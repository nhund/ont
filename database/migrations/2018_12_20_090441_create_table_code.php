<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('code')) {
            Schema::create('code', function (Blueprint $table) {
                $table->increments('id');
                $table->text('code')->nullable();             
                $table->integer('price')->nullable(); 
                $table->integer('created_at')->nullable(); 
                $table->integer('status')->nullable(); 
                $table->integer('end_date')->nullable(); 
                
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
