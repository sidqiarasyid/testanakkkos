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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id');
            $table->foreignId('user_id');
            $table->string('order_id');
            $table->string('status');
            $table->string('kost_name');
            $table->string('kost_type');
            $table->string('location');
            $table->string('stay_duration');
            $table->integer('total_price');
            $table->integer('electricity')->nullable();
            $table->integer('room_price');
            $table->string('due_date');
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
        Schema::dropIfExists('transactions');
    }
};
