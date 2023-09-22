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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('slug',255)->unique();
            $table->string('description',500)->nullable();
            $table->text('content')->nullable();
            $table->string('image',255)->nullable();
            $table->boolean('status')->default(1)->comment('1 = Active, 2 = Inactive');
            $table->boolean('is_menu')->default(1)->comment('1 = Active, 2 = Inactive');
            $table->integer('parrent_id')->nullable();
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
        Schema::dropIfExists('category');
    }
};
