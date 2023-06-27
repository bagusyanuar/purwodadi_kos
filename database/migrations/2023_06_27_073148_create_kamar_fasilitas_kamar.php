<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKamarFasilitasKamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamar_fasilitas_kamar', function (Blueprint $table) {
            $table->primary(['kamar_id', 'fasilitas_kamar_id']);
            $table->bigInteger('kamar_id')->unsigned();
            $table->bigInteger('fasilitas_kamar_id')->unsigned();
            $table->foreign('kamar_id')->references('id')->on('kamar');
            $table->foreign('fasilitas_kamar_id')->references('id')->on('fasilitas_kamar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamar_fasilitas_kamar');
    }
}
