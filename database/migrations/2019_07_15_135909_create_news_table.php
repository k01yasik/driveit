<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 191)->unique();
            $table->string('title', 255);
            $table->text('description');
            $table->string('name', 255);
            $table->text('caption');
            $table->text('body');
            $table->text('image_path');
            $table->boolean('is_published');
            $table->dateTime('date_published')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('views');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
