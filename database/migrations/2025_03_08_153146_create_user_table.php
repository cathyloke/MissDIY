<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('user', function (Blueprint $table) {
        //     $table->string('id', 21)->primary();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->string('password');
        //     $table->text('address')->nullable();
        //     $table->enum('gender', ['male', 'female', 'other'])->nullable();
        //     $table->enum('type', ['admin', 'customer']); 
        //     $table->string('contact_number')->nullable();
        //     $table->timestamps(); 
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
