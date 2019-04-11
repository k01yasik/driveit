<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSshinaCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sshina_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('us_name')->nullable();
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
        Schema::dropIfExists('sshina_categories');
    }
}
