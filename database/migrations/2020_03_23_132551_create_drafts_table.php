<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 191)->unique()->index();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('name', 255)->nullable();
            $table->text('caption')->nullable();
            $table->text('body')->nullable();
            $table->text('image_path')->nullable();
            $table->boolean('is_published')->default(false);
            $table->dateTime('date_published')->nullable();
            $table->unsignedInteger('user_id');
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drafts');
    }
}
