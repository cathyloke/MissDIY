<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_voucher', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('salesId', 21);
            $table->string('voucherId', 21);
            $table->timestamps();

            $table->foreign('salesId')->references('id')->on('sales')->onDelete('no action');
            $table->foreign('voucherId')->references('id')->on('voucher')->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_voucher');
    }
}
