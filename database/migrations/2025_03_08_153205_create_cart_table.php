<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('userId', 21);
            $table->string('productId', 21);
            $table->string('productImg', 255);
            $table->string('productName', 255);
            $table->decimal('productPrice', 10, 2);
            $table->unsignedInteger('productQty')->default(0);
            $table->timestamps(); 

            $table->foreign('userId')->references('id')->on('user')->onDelete('no action');
            $table->foreign('productId')->references('id')->on('product')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
