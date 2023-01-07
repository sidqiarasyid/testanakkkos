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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            //Tempat Tidur
            $table->boolean('bantal');
            $table->boolean('guling');
            $table->boolean('kasur');
            //Kebersihan
            $table->boolean('kamar-mandi');
            $table->boolean('laundry');
            //Konsumsi
            $table->boolean('dapur');
            $table->boolean('kulkas');
            $table->boolean('catering');
            //Hiburan
            $table->boolean('wifi');
            $table->boolean('tv');
            //Furniture
            $table->boolean('lemari');
            $table->boolean('meja');
            $table->boolean('kursi');
            //Udara
            $table->boolean('ac');
            $table->boolean('kipas');
            $table->boolean('jendela');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
};
