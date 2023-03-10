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
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->string('kost_name');
            $table->string('location');
            $table->integer('rating');
            $table->string('total_transaction');
            $table->string('rules');
            $table->string('payment_period');
            $table->integer('wifi_price');
            $table->integer('elec_price');
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
        Schema::dropIfExists('kosts');
    }
};
