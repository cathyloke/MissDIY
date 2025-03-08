<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->unsignedInteger('quantity')->default(0);
            $table->string('productId', 21);
            $table->string('salesId', 21);
            $table->string('userId', 21);
            $table->timestamps(); 

            $table->foreign('productId')->references('id')->on('product')->onDelete('no action');
            $table->foreign('salesId')->references('id')->on('sales')->onDelete('no action');
            $table->foreign('userId')->references('id')->on('user')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_details');
    }
}
