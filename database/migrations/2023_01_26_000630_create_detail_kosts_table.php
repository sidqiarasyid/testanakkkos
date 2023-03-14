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
        Schema::create('detail_kosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id');
            $table->foreignId('kost_id');
            $table->integer('profit');
            $table->string('avg_rating');
            $table->integer('unit_rented');
            $table->integer('unit_open');
            $table->string('kost_name');
            $table->string('status');
            $table->string('kost_img')->nullable();
            $table->string('kost_location');
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
        Schema::dropIfExists('detail_kosts');
    }
};
