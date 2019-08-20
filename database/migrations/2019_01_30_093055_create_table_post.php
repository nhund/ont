<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('post')) {
            Schema::create('post', function (Blueprint $table) {
                $table->increments('id');                       
                $table->integer('category_id')->nullable();
                $table->string('name',255)->nullable();
                $table->text('url')->nullable();       
                $table->text('content')->nullable();
                $table->text('des')->nullable();
                $table->text('avatar')->nullable();
                $table->integer('status')->nullable();  
                $table->integer('sicky')->nullable();  
                $table->string('seo_title',255)->nullable();
                $table->string('seo_description',255)->nullable();
                $table->string('seo_keyword',255)->nullable();                       
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
