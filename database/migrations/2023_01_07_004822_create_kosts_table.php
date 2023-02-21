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
            $table->string('acc_status');
            $table->foreignId('seller_id');
            $table->string('kost_name');
            $table->string('location');
            $table->string('location_url');
            $table->string('kost_type');
            $table->integer('rating');
            $table->string('width');
            $table->string('weight');
            $table->string('room_rules');
            $table->string('kost_rules');
            $table->string('desc');
            $table->integer('unit_open');
            $table->integer('total_unit');
            $table->integer('room_price');
            $table->integer('elec_price')->nullable();
            $table->integer('total_price');
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
