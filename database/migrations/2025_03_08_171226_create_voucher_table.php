<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->string('id', 21)->primary();
            $table->string('code')->unique(); 
            $table->decimal('discount', 10, 2); 
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('minimumSpend', 10, 2); 
            $table->date('expiration_date')->nullable(); 
            $table->enum('validity', ['active', 'inactive'])->default('active'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher');
    }
}
