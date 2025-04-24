<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->timestamp('date');
            $table->decimal('totalAmount', 10, 2);
            $table->decimal('netTotalAmount', 10, 2);
            $table->enum('status', ['pending', 'delivering', 'completed'])->default('pending');
            $table->string('userId', 21);
            $table->timestamps(); 

            $table->foreign('userId')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
