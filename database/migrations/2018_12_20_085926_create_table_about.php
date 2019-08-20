<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAbout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('about')) {
            Schema::create('about', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title',255)->nullable();
                $table->text('url')->nullable();
                $table->string('address',255)->nullable();   
                $table->string('phone',255)->nullable();
                $table->string('email')->nullable();
                $table->text('about_us')->nullable(); 
                $table->text('page_facebook')->nullable(); 
                $table->text('group_facebook')->nullable(); 
                $table->integer('create_date')->nullable(); 
                $table->text('logo')->nullable(); 
                $table->text('map')->nullable(); 
                $table->integer('status')->nullable(); 
                $table->text('twitter')->nullable();       
                $table->text('google')->nullable();       
                $table->text('instagram')->nullable();       
                $table->text('youtube')->nullable();       
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
