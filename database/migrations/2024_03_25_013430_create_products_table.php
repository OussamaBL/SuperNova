<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->double('price');
            $table->double('discounted_price');
            $table->string('reference');
            $table->text('image');
            $table->integer('qte');
            $table->integer('qte_dispo');
            $table->boolean('in_stock');
            $table->bigInteger('id_sub_catg')->unsigned();
            $table->foreign('id_sub_catg')->references('id')->on('sub_categories');

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
        Schema::dropIfExists('products');
    }
};
