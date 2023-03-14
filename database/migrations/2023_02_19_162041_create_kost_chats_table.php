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
        Schema::create('kost_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('seller_id');
            $table->string('seller_name');
            $table->foreignId('kost_id');
            $table->string('user_pfp');
            $table->string('seller_pfp');
            $table->string('username');
            $table->string('kost_name');
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
        Schema::dropIfExists('kost_chats');
    }
};
