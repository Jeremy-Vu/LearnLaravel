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
            $table->string('name',255);
            $table->decimal('price', 12,2);
            $table->string('slug',255)->unique();
            $table->string('image')->nullable();
            $table->string('sku',55);
            $table->text('detail_product')->nullable();
            $table->longText('description')->nullable();
            $table->integer('brand_id');
            $table->integer('category_id');
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
