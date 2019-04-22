<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('suggest');
            $table->timestamps();
        });

        Schema::table('category_post', function (Blueprint $table) {
            $table->dropForeign('category_post_post_id_foreign');

            $table->unsignedBigInteger('post_id')->change();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_post_id_foreign');

            $table->unsignedBigInteger('post_id')->change();
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign('ratings_post_id_foreign');

            $table->unsignedBigInteger('post_id')->change();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
        });

        Schema::table('category_post', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
        });

        Schema::table('suggests', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('suggest')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suggests');
    }
}
