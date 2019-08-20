<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableError extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('error')) {
            Schema::create('error', function (Blueprint $table) {
                $table->increments('id');
                $table->string('request_uri',255)->nullable();
                $table->string('method',255)->nullable();
                $table->string('parameters',255)->nullable();    
                $table->text('message')->nullable();    
                $table->string('code',255)->nullable();    
                $table->string('file',255)->nullable();    
                $table->string('line',255)->nullable();
                $table->text('trace')->nullable();       
                $table->integer('is_read')->nullable();            
                $table->integer('create_date')->nullable();                                                                
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
