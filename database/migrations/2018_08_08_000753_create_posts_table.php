<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 191)->unique();
            $table->string('title', 255);
            $table->text('description');
            $table->string('name', 255);
            $table->text('caption');
            $table->text('body');
            $table->text('image_path');
            $table->boolean('is_published');
            $table->dateTime('date_published')->nullable();
            $table->integer('user_id');
            $table->integer('views');
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
        Schema::dropIfExists('posts');
    }
}
