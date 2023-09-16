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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name',55);
            $table->decimal('price', 9,2);
            $table->string('slug');
            $table->string('image')->nullable();
            $table->integer('quantity');
            $table->integer('quantity_sell')->nullable();
            $table->integer('quantity_left')->nullable();
            $table->string('sku');
            $table->string('detail_product', 255);
            $table->integer('brand_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('product');
    }
};
