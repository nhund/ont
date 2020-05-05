<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('status');
            $table->timestamps();
        });

        Schema::table('post', function (Blueprint $table) {
            $table->string('avatar_path');
            $table->string('type')->default(\App\Models\Post::POSTING);
            $table->integer('feature')->default(\App\Models\Post::NORMAL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post', function (Blueprint $table) {
            $table->dropColumn('avatar_path');
            $table->dropColumn('type');
            $table->dropColumn('feature');
        });

        Schema::dropIfExists('category_news');
    }
}
