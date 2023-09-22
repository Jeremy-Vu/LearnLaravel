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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name_customer',55);
            $table->integer('customer_id')->nullable();
            $table->string('phone');
            $table->string('address',255);
            $table->string('payment_method',55);
            $table->boolean('status')->default(1);
            $table->string('order_code');
            $table->string('order_note')->nullable();
            $table->decimal('total_amount',12,2);
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};
