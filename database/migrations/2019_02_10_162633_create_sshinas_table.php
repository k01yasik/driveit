<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSshinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sshinas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('vendor');
            $table->text('offer_id');
            $table->text('url');
            $table->unsignedInteger('price')->index();
            $table->string('currency_id', 10);
            $table->unsignedInteger('category_id');
            $table->text('picture');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('sshina_categories');

            $table->index([DB::raw('vendor(20)')]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sshinas');
    }
}
