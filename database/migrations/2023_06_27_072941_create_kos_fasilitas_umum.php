<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKosFasilitasUmum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kos_fasilitas_umum', function (Blueprint $table) {
            $table->primary(['kos_id', 'fasilitas_umum_id']);
            $table->bigInteger('kos_id')->unsigned();
            $table->bigInteger('fasilitas_umum_id')->unsigned();
            $table->foreign('kos_id')->references('id')->on('kos');
            $table->foreign('fasilitas_umum_id')->references('id')->on('fasilitas_umum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kos_fasilitas_umum');
    }
}
